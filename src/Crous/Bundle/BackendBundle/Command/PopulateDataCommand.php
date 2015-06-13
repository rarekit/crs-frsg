<?php
namespace Crous\Bundle\BackendBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class PopulateDataCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this->setName('crous:populate:data')
            ->setDescription('Populating date')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        if ($this->populateUser($em)) {
            $output->writeln("<fg=green>Populating user data successful!</fg=green>");       
        }

    }

    protected function truncate($em, $clsName)
    {
        $cmd = $em->getClassMetadata($clsName);
        $connection = $em->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        $connection->beginTransaction();

        try {
            $connection->query('SET FOREIGN_KEY_CHECKS=0');
            $q = $dbPlatform->getTruncateTableSql($cmd->getTableName());
            $connection->executeUpdate($q);
            $connection->query('SET FOREIGN_KEY_CHECKS=1');
            $connection->commit();
            return true;
        }
        catch (\Exception $e) {
            $connection->rollback();
        }

        return false;
    }

    protected function populateUser($em)
    {
        if ($this->truncate($em, 'Crous\Bundle\BackendBundle\Entity\User')) {
            $users = array(
                array('admin', 'admin', 'Johnny', 'Depp', 'ROLE_ADMIN', 'admin@crous.com', true),
            );
            /* @var $userManager \Crous\Bundle\BackendBundle\Manager\UserManager */
            $userManager = $this->getContainer()->get('user_manager');
            foreach ($users as $item) {
                /* @var $user \Crous\Bundle\BackendBundle\Entity\User */
                $user = $userManager->createObject();
                $user->setUsername($item[0])
                    ->setRegionId(1)
                    ->setPassword($item[1])
                    ->setFirstname($item[2])
                    ->setLastname($item[3])
                    ->setEmail($item[5])
                    ->setRole(1)
                    ->setActive(1)
                    ;

                /*$role = $roleManager->getRepository()->findOneBy(array('role'=>$item[4]));
                if ($role instanceof \Crous\Bundle\BackendBundle\Entity\Role) {
                    $user->setRole($role->getId());            
                }*/

                //Encrypt password
                $factory = $this->getContainer()->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);        
                $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());  

                $user->setPassword($password);
                $userManager->save($user);

                return true;
            }
        }

        return false;
    }
}
