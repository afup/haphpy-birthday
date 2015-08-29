<?php

class RoboFile extends \Robo\Tasks
{
    use Agallou\RoboHash\loadTasks;

    public function watch()
    {
        $this->build();

        $buildCss = function () {
            $this->_cleanBase();
            $this->_cleanCss();
            $this->_buildCss();
        };

        $this
            ->taskWatch()
            ->monitor(array('app/Resources/assets/sass/main.scss'), $buildCss)
            ->run()
            ;
    }

    public function install()
    {
        $this->getDeps();
        $this->build();
    }

    protected function getDeps()
    {
        $this->_cleanDir('bower_components/');
        $this->taskBowerInstall('./bin/bowerphp')->run();

        //Il n'y a pas de tag d'Elaostrap contenant les fichiers dist
        //on clone donc le repo. Une fois qu'il y en aura un il faudra passer
        //par le fichier bower.json
        $this->taskGitStack()
            ->cloneRepo('https://github.com/JeremyFagis/ElaoStrap.git', 'bower_components/ElaoStrap')
            ->run()

        ;

    }

    public function build()
    {
        $this->_clean();
        $this->_buildCss();
        $this->_buildJs();
        $this->_buildOtherAssets();
    }

    protected function _buildCss()
    {
        $this
            ->taskScss(['app/Resources/assets/sass/main.scss' => 'app/cache/assets/sass/main_sass.css'])
            ->addImportPath('app/Resources/assets/sass')
            ->run();

        $this
            ->taskConcat([
                'bower_components/ElaoStrap/dist/css/style.css',
                'app/cache/assets/sass/main_sass.css',
            ])
            ->to('app/cache/main.css')
            ->run()
        ;

        $this
            ->taskMinify('app/cache/main.css')
            ->to('web/assets/css/main.css')
            ->run()
        ;

        $this->taskHash('web/assets/css/main.css')->to('web/assets/css/')->run();
    }

    protected function _buildJs()
    {
        $this
            ->taskConcat([
                'bower_components/ElaoStrap/dist/js/main.js',
            ])
            ->to('app/cache/assets/main.js')
            ->run()
        ;

        $this
            ->taskMinify('app/cache/assets/main.js')
            ->to('web/assets/js/main.js')
            ->run()
        ;

        $this->taskHash('web/assets/js/main.js')->to('web/assets/js/')->run();
    }

    protected function _clean()
    {
        $this->_mkdir('app/cache/assets/');
        $this->_cleanBase();
        $this->_cleanCss();
        $this->_cleanJs();
        $this->_cleanOtherAssets();

    }

    protected function _cleanBase()
    {
        $this->_cleanDir('app/cache/assets/');
    }

    protected function _cleanCss()
    {
        $this->_mkdir('web/assets/css');
        $this->_cleanDir('web/assets/css');
        $this->_mkdir('app/cache/assets/sass');
        $this->_cleanDir('app/cache/assets/sass');
    }

    protected function _cleanJs()
    {
        $this->_mkdir('web/assets/js');
        $this->_cleanDir('web/assets/js');
    }

    protected function _cleanOtherAssets()
    {
        $this->_mkdir('web/assets/icons');
        $this->_mkdir('web/assets/images');
        $this->_mkdir('web/assets/videos');
        $this->_mkdir('web/assets/fonts');

        $this->_cleanDir('web/assets/icons');
        $this->_cleanDir('web/assets/images');
        $this->_cleanDir('web/assets/videos');
        $this->_cleanDir('web/assets/fonts');
    }

    protected function _buildOtherAssets()
    {
        $this->_copyDir('app/Resources/assets/icons', 'web/assets/icons');
        $this->_copyDir('app/Resources/assets/images', 'web/assets/images');
        $this->_copyDir('bower_components/ElaoStrap/dist/images', 'web/assets/images');
        $this->_copyDir('app/Resources/assets/videos', 'web/assets/videos');
        $this->_copyDir('bower_components/ElaoStrap/dist/fonts/elaostrap', 'web/assets/fonts/elaostrap');
        $this->_copyDir('bower_components/fontawesome/fonts', 'web/assets/fonts/font-awesome');
        $this->_copyDir('bower_components/dropify/dist/fonts', 'web/assets/fonts/dropify');

    }
}
