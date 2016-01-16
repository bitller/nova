<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test paginate only not allowed user actions admin feature.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class PaginateOnlyNotAllowedUserActionsTest extends TestCase {

    use DatabaseTransactions;
    use WithoutMiddleware;
    
}