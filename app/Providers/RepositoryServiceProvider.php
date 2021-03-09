<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->registerCompaniesRepository();
        $this->registerProjectsRepository();
        $this->registerTasksRepository();
        $this->registerUsersRepository();
        $this->registerCommentsRepository();
    }

    public function registerUsersRepository()
    {
    	return $this->app->bind
        (
            'App\Repositories\UserRepositories\UserRepositoryInterface', 
            'App\Repositories\UserRepositories\UserRepository'
        );
    }

    public function registerCompaniesRepository()
    {
    	return $this->app->bind
        (
            'App\Repositories\CompanyRepositories\CompanyRepositoryInterface', 
            'App\Repositories\CompanyRepositories\CompanyRepository'
        );
    }

    public function registerProjectsRepository()
    {
    	return $this->app->bind
        (
            'App\Repositories\ProjectRepositories\ProjectRepositoryInterface', 
            'App\Repositories\ProjectRepositories\ProjectRepository'
        );
    }

    public function registerTasksRepository()
    {
    	return $this->app->bind
        (
            'App\Repositories\TaskRepositories\TaskRepositoryInterface', 
            'App\Repositories\TaskRepositories\TaskRepository'
        );
    }

    public function registerCommentsRepository()
    {
        return $this->app->bind
        (
            'App\Repositories\CommentRepositories\CommentRepositoryInterface', 
            'App\Repositories\CommentRepositories\CommentRepository'
        );
    }
}

?>