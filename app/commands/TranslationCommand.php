<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class TranslationCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'command:translation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert language files to json.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {

        $languages = File::directories(base_path().'/app/lang/');

        foreach ($languages as $language)
        {
            $tmp = explode('/', $language);
            $langs[] = end($tmp);
        }

        foreach ($langs as $lang)
        {
            $tmp = File::allFiles(base_path().'/app/lang/'.$lang);

            foreach ($tmp as $v) {
                $names[] = current(explode('.',$v->getRelativePathname()));
            }

        }

        foreach ($names as $name)
        {
            $content = Lang::get($name);

            file_put_contents('app/storage/translations/'.$name.'.json', json_encode($content, JSON_PRETTY_PRINT));

            $this->info('Translation file '.$name.' was created.');
        }

    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }

}
