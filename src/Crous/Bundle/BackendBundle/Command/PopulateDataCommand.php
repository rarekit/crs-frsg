<?php

namespace Crous\Bundle\BackendBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;

class PopulateDataCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this->setName('crous:populate:data')
                ->setDescription('Populating data')
                ->addArgument(
                    'name',
                    InputArgument::OPTIONAL,
                    'Who do you want to greet?'
                )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();

        $name = $input->getArgument('name');
        switch ($name) {
            case 'all':
                if ($this->populateRole($em)) {
                    $output->writeln("<fg=green>Populating role data successful!</fg=green>");
                }
                if ($this->populateUser($em)) {
                    $output->writeln("<fg=green>Populating user data successful!</fg=green>");
                }
                if ($this->populateParams($em)) {
                    $output->writeln("<fg=green>Populating parameters successful!</fg=green>");
                }
                break;
            case 'params':
                if ($this->populateParams($em)) {
                    $output->writeln("<fg=green>Populating parameters successful!</fg=green>");
                }
                break;
            
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
        } catch (\Exception $e) {
            $connection->rollback();
        }

        return false;
    }

    protected function populateUser($em)
    {
        if ($this->truncate($em, 'Crous\Bundle\BackendBundle\Entity\User')) {
            $users = array(
                array('admin', '123456', 'Phat', 'Nguyen', 'ROLE_ADMIN', 'admin@admin.com', true),
            );
            /* @var $userManager \Crous\Bundle\BackendBundle\Manager\UserManager */
            $userManager = $this->getContainer()->get('manager_factory')->create('user');
            $roleManager = $this->getContainer()->get('manager_factory')->create('role');
            foreach ($users as $item) {
                /* @var $user \Crous\Bundle\BackendBundle\Entity\User */
                $user = $this->getContainer()->get('entity_factory')->create('user');
                $user->setUsername($item[0])
                        ->setPassword($item[1])
                        ->setFirstname($item[2])
                        ->setLastname($item[3])
                        ->setEmail($item[5])
                        ->setActive(true)
                ;

                $role = $roleManager->getRepository()->findOneBy(array('role' => $item[4]));
                if ($role != null && $role instanceof \Crous\Bundle\BackendBundle\Entity\Role) {
                    $user->setRole($role);
                }

                //Encrypt password
                $factory = $this->getContainer()->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $password = $encoder->encodePassword($user->getPassword(), '');

                $user->setPassword($password);
                $userManager->save($user);
                return true;
            }
        }
        return false;
    }

    protected function populateRole($em)
    {
        if ($this->truncate($em, 'Crous\Bundle\BackendBundle\Entity\Role')) {
            $roles = array(
                array('Administrator', 'ROLE_ADMIN'),
                array('Standard User', 'ROLE_USER'),
                array('Guest', 'ROLE_GUEST'),
            );
            /* @var $roleManager \Crous\Bundle\BackendBundle\Manager\RoleManager */
            $roleManager = $this->getContainer()->get('manager_factory')->create('role');
            foreach ($roles as $item) {
                /* @var $role \Crous\Bundle\BackendBundle\Entity\Role */
                $role = $this->getContainer()->get('entity_factory')->create('role');
                $role->setName($item[0])
                        ->setRole($item[1])
                        ->setType(1)
                        ->setActive(true)
                ;
                $roleManager->save($role);
            }
            return true;
        }
        return false;
    }

    protected function populateParams($em)
    {
        if ($this->truncate($em, 'Crous\Bundle\BackendBundle\Entity\Params')) {
            $params = array(
                array('dtd_url', 'http://ftp.crous.parking.einden.com/'),
                array('push_url', 'http://ynp.sophiacom.fr/ynp/sandbox/sendNotification'),
                array('push_api_key', 'api_key'),
                array('push_shared_secret', 'secret'),
                array('push_appname', 'com.youandpush.myapp'),
                array('push_project', 'projectkey'),
                array('export_ftp_host', '10.0.0.3'),
                array('export_ftp_user', 'fptuser'),
                array('export_ftp_passwd', '123456'),
            );
            /* @var $paramsManager \Crous\Bundle\BackendBundle\Manager\ParamsManager */
            $paramsManager = $this->getContainer()->get('manager_factory')->create('params');
            foreach ($params as $item) {
                /* @var $role \Crous\Bundle\BackendBundle\Entity\Params */
                $param = $this->getContainer()->get('entity_factory')->create('params');
                $param->setName($item[0])
                        ->setValue($item[1])
                ;
                $paramsManager->save($param);
            }
            return true;
        }
        return false;
    }

}
