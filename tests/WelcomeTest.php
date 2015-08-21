<?php

/**
 * WelcomeTest
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class WelcomeTest extends TestCase {

    /**
     * Access Welcome page as a visitor
     */
    public function testWelcomePageAsVisitor() {

        $this->visit('/')
            ->see(trans('welcome.welcome'));

    }

}