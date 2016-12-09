<?php

namespace Fgms\EmailInquiriesBundle\Command;

class ImportCommand extends BaseCommand
{
    protected function configure()
    {
        $this->setName('emailinquiries:import');
        $this->setDescription('Imports a form from a configuration file.');
        $this->setHelp('Imports a configuration file to update or create a Form entity (and associated Field entities) which are then persisted via Doctrine.');
        $this->setDefinition(
            new \Symfony\Component\Console\Input\InputDefinition([
                new \Symfony\Component\Console\Input\InputArgument(
                    'filename',
                    \Symfony\Component\Console\Input\InputArgument::REQUIRED
                )
            ])
        );
    }

    private function getConfiguration($filename)
    {
        $ext = preg_replace('/^.*\\.([^\\.]+)$/u','$1',$filename);
        if (($ext === 'yaml') || ($ext === 'yml')) return new \Fgms\EmailInquiriesBundle\Configuration\YamlConfiguration();
        throw new \RuntimeException(
            sprintf(
                'Cannot produce ConfigurationInterface instance for file extension .%s',
                $ext
            )
        );
    }

    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output)
    {
        $filename = $input->getArgument('filename');
        $str = @file_get_contents($filename);
        if ($str === false) throw new \RuntimeException(
            sprintf(
                'Could not read file %s',
                $filename
            )
        );
        $config = $this->getConfiguration($filename);
        $config->load($str);
        $form = null;
        $repo = $this->getFormRepository();
        $id = $config->getId();
        if (!is_null($id)) {
            $form = $repo->findOneById($id);
            if (is_null($form)) throw new \RuntimeException(
                sprintf(
                    'No Form with ID %d',
                    $id
                )
            );
        } else {
            $key = $config->getKey();
            if (!is_null($key)) $form = $repo->findOneByKey($key);
        }
        $form = $config->execute($form);
        $em = $this->getEntityManager();
        $em->persist($form);
        $em->flush();
    }
}
