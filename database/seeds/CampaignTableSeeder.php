<?php

/**
 * Seeds campaigns table.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class CampaignTableSeeder extends \Illuminate\Database\Seeder {

    public function run() {

        // Campaigns for 2016
        $campaigns = [
            [
                'year' => 2016,
                'start_date' => '2015-12-28',
                'end_date' => '2016-01-20',
                'number' => 1
            ], [
                'year' => 2016,
                'start_date' => '2016-01-21',
                'end_date' => '2016-02-10',
                'number' => 2
            ], [
                'year' => 2016,
                'start_date' => '2016-02-11',
                'end_date' => '2016-03-02',
                'number' => 3
            ], [
                'year' => 2016,
                'start_date' => '2016-03-03',
                'end_date' => '2016-03-23',
                'number' => 4
            ], [
                'year' => 2016,
                'start_date' => '2016-03-24',
                'end_date' => '2016-04-13',
                'number' => 5
            ], [
                'year' => 2016,
                'start_date' => '2016-04-14',
                'end_date' => '2016-05-04',
                'number' => 6
            ], [
                'year' => 2016,
                'start_date' => '2016-05-05',
                'end_date' => '2016-05-25',
                'number' => 7
            ], [
                'year' => 2016,
                'start_date' => '2016-05-26',
                'end_date' => '2016-06-15',
                'number' => 8
            ], [
                'year' => 2016,
                'start_date' => '2016-06-16',
                'end_date' => '2016-07-06',
                'number' => 9
            ], [
                'year' => 2016,
                'start_date' => '2016-07-07',
                'end_date' => '2016-07-27',
                'number' => 10
            ], [
                'year' => 2016,
                'start_date' => '2016-07-28',
                'end_date' => '2016-08-17',
                'number' => 11
            ], [
                'year' => 2016,
                'start_date' => '2016-08-18',
                'end_date' => '2016-09-07',
                'number' => 12
            ], [
                'year' => 2016,
                'start_date' => '2016-09-08',
                'end_date' => '2016-09-28',
                'number' => 13
            ], [
                'year' => 2016,
                'start_date' => '2016-09-29',
                'end_date' => '2016-10-19',
                'number' => 14
            ], [
                'year' => 2016,
                'start_date' => '2016-10-20',
                'end_date' => '2016-11-09',
                'number' => 15
            ], [
                'year' => 2016,
                'start_date' => '2016-11-10',
                'end_date' => '2016-11-30',
                'number' => 16
            ], [
                'year' => 2016,
                'start_date' => '2016-12-01',
                'end_date' => '2016-12-28',
                'number' => 17
            ]
        ];

        foreach ($campaigns as $campaign) {
            \App\Campaign::create($campaign);
        }

    }

}