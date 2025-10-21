<?php

namespace App\Http\Controllers;

use App\Http\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UtilityController extends Controller
{
    /**
     * Root API endpoint
     */
    public function index()
    {
        return Api::message('ready!');
    }

    /**
     * List directory contents
     */
    public function listDirectory()
    {
        return Api::data(scandir(base_path(request('path'))));
    }

    /**
     * Get environment variables
     */
    public function getEnvironment()
    {
        return Api::data(request('key') ? env(request('key')) : getenv());
    }

    /**
     * Get configuration values
     */
    public function getConfig()
    {
        return Api::data(config(request('key')));
    }

    /**
     * Get database configuration
     */
    public function getDatabaseConfig()
    {
        return Api::data(DB::connection()->getConfig());
    }
}
