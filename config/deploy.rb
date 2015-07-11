# config valid only for current version of Capistrano
lock '3.4.0'

set :application, 'haphpy-birthday'
set :repo_url, 'git@github.com:afup/haphpy-birthday.git'
set :app_path, 'app'

# Default branch is :master
# ask :branch, `git rev-parse --abbrev-ref HEAD`.chomp
set :branch, :master

# Default deploy_to directory is /var/www/my_app_name
set :deploy_to, '/home/haphpy/haphpy-birthday.net'

# Default value for :scm is :git
# set :scm, :git

# Default value for :format is :pretty
# set :format, :pretty

# Default value for :log_level is :debug
# set :log_level, :debug

# Default value for :pty is false
# set :pty, true

# Symfony variables
set :app_path, 'app'
set :web_path, 'web'
set :log_path, fetch(:app_path) + "/logs"
set :cache_path, fetch(:app_path) + "/cache"
set :app_config_path, fetch(:app_path) + "/config"
set :file_permissions_paths, [fetch(:log_path), fetch(:cache_path)]
set :file_permissions_users, ['www-data']
set :permission_method, :acl
set :use_set_permissions, true

# Default value for :linked_files is []
set :linked_files, fetch(:linked_files, []).push(fetch(:app_config_path) + '/parameters.yml')

# Default value for linked_dirs is []
set :linked_dirs, fetch(:linked_dirs, []).push(fetch(:log_path))

# Default value for default_env is {}
# set :default_env, { path: "/opt/ruby/bin:$PATH" }

# Default value for keep_releases is 5
# set :keep_releases, 5


namespace :deploy do

  after :restart, :clear_cache do
    on roles(:web), in: :groups, limit: 3, wait: 10 do
      # Here we can do anything such as:
      # within release_path do
      #   execute :rake, 'cache:clear'
      # end
    end
  end

end
