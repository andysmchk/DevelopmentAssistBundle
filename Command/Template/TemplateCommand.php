<?php

namespace Rewsam\DevelopmentAssist\Command\Template;

use Rewsam\DevelopmentAssist\Service\Template\Parameter\InputParameter;
use Rewsam\DevelopmentAssist\Service\Template\Templating;
use Rewsam\DevelopmentAssist\Service\Template\TemplatingRegistry;
use Rewsam\DevelopmentAssist\Service\Template\Writer\Writer;
use Rewsam\DevelopmentAssist\Service\Template\Writer\WriterBuilder;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

class TemplateCommand extends ContainerAwareCommand
{
    public function configure()
    {
        $this
            ->setName('assist:template:generate')
            ->addOption('dry', null, InputOption::VALUE_NONE, 'Execute but don\'t save changes to the filesystem')
            ->setDescription('Generates scripts and classes from the given template')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $templating = $this->getTemplating($input, $output);
        $params = $this->collectInputParams($templating, $input, $output);
        $template = $templating->prepare($params);
        $writer = $this->getWriter($input, $output);
        $template->save($writer);
    }

    private function collectInputParams(Templating $templating, InputInterface $input, OutputInterface $output)
    {
        $params = [];
        $helper = $this->getHelper('question');

        foreach ($templating->getInputParameterDefinitions() as $inputParameterDefinition) {
            $question = new Question(sprintf('Please define %s: ', $inputParameterDefinition->getName()));

            $value = $helper->ask($input, $output, $question);
            $params[] = InputParameter::createFromDefinition($inputParameterDefinition, $value);
        }

        return $params;
    }

    private function getTemplating(InputInterface $input, OutputInterface $output): Templating
    {
        /** @var TemplatingRegistry $templatingRegistry */
        $templatingRegistry = $this->getContainer()->get(TemplatingRegistry::class);
        $question = new ChoiceQuestion('Please select template name: ', $templatingRegistry->getKeys());
        $templateName = $this->getHelper('question')->ask($input, $output, $question);

        return $templatingRegistry->get($templateName);
    }

    private function getWriter(InputInterface $input, OutputInterface $output): Writer
    {
        return (new WriterBuilder())
            ->setDry($input->getOption('dry'))
            ->setOutput($output)
            ->build();
    }
}