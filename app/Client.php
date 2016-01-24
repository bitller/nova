<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Client model
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class Client extends Model {

    /**
     * @var array
     */
    protected $fillable = ['name', 'email', 'phone_number', 'user_id'];
}
