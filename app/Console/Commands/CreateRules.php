<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Vps\Rules;

class CreateRules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Rules:Change';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change Rules to User';

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
    public function handle()
    {

        $rules = [
            'portfolios'=>
                ['is_enable' => true,
                    'child_rules' =>
                        [
                            'INBX' => true,
                            'SOF' => true,
                            'IBC' => true,
                            'COMET' => true
                        ]
                ],
            'hr'=> 
                ['is_enable' => true,
                    'child_rules' =>
                    [
                        'nteform' => true,
                        'formlist' => true,
                        'provision' => true,
                        'gravity' => true,
                        'ntecategory' => true,
                        'correctiveaction' => true
                    ]
                ],
            'ticketing' =>
                ['is_enable' => true,
                    'child_rules' =>
                    [
                        'tracking' => true
                    ]

                ],
            'action' =>
                ['is_enable' => true,
                    'child_rules' =>
                    [
                        'agentsurvey' => true
                    ]

                ],
                
            'tk'=> ['child_rules' =>
                [
                    'workweek' => true,
                ]
            ], // Loan approval template

//            //payment manager
//            'paymentmanager' => ['is_enable' => true,
//                'child_rules' =>
//                    [
//                        'search' => true,
//                        'changes' => true
//                    ]
//            ],
            'loanapproval'=>
                ['is_enable' => true,
                    'child_rules' =>
                    [
                        'application_form' => true,
                        'application_list' => ['is_enable' => true,
                                'child_rules' =>
                                    [
                                        'grab_app' => false,
                                        'queue_app' => false,
                                        'pending_app' => false,
                                        'approved_app' => false,
                                        'correction_app' => false,
                                        'deny_app' => false,
                                    ],
                            ],
                        'application_action' => ['is_enable' => true,
                                    'child_rules' =>
                                        [
                                            'view_app' => false,
                                            'reassign_app' => false,
                                            'process_app' => false,
                                            'update_app' => false,
                                            'correction_app' => false,
                                            'return_app' => false,
                                            'deny_app' => false,
                                            'approve_app' => false,
                                        ],
                                  ],
                        'dcinfo' => true,
                        'buttonsave' => true,
                        'badaba' => true,
                        'adjustmentfinancefee' => true,
                        'uncrypted_cc' => true,
                        'reassignapp' => true,
                        'corrections' => true
                    ]
                ],
            'settings'=>
                ['is_enable' => true,
                    'child_rules' =>
                    [
                        'usersgroups' => true,
                        'aclrules' => true,
                        'department' => true,
                        'designation' => true,
                        'costcenter' => true,
                        'officelocation' => true,
                        'employmenttype' => true,
                        'employees' => true,
                        'portfolios' => true,
                        'states' => true,
                        'tags' => true,
                        'actionsurvey' => true,
                    ]
                ],
            'qa'=>
                ['is_enable' => true,
                    'child_rules' =>
                    [
                        'dashboard' => true,
                        'form' =>

                            ['is_enable' => true,
                                'child_rules' =>
                                 [
                                    'formlist' => true,
                                    'auditstatus' => true,
                                    'coachinglogs' => true,
                                    'disputes' => true,
                                    'clarification' => true,
                                 ],
                            ],
                        'qareports' =>
                            ['is_enable' => true,
                                'child_rules' =>
                                [
                                    'monthlyscore' => false,
                                    'scoresummary' => true,
                                    'generatesummary' => true,
                                    'detailedreport' => true,
                                    'statusreport' => true,
                                ],
                            ],
                        'qasettings' =>

                            ['is_enable' => true,
                                'child_rules' =>
                                [
                                    'categories' => true,
                                    'subcategories' => true,
                                    'descriptions' => true,
                                    'importemployee' => true,
                                    'user' => true,
                                ],
                            ],
                    ]
                ]
        ];

//         Rules::where('user_id', 747)
//             ->update(['rules' => json_encode($rules)]);
        Rules::where('user_id', 747)
            ->update(['rules' => json_encode($rules)]);
    }
}
