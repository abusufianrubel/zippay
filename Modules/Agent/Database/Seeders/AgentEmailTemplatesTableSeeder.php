<?php

namespace Modules\Agent\Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AgentEmailTemplatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        EmailTemplate::insert([

            // Notice for Agent Registration
            [
                'name' => 'Notice for Agent Registration',
                'alias' => 'notice-for-agent-registration',
                'subject' => 'Notice for Agent Registration',
                'body' => 'Hi <b>{agent}</b>,<br><br>Congratulations! You have been successfully registered as an agent by our admin. <div><br></div><div>Your Account Details: </div><div>Name: <b>{agent}</b></div><div>Email: <b>{email}</b> </div><div>Password: <b>{password}</b></div><div><br></div><div>You can now log in to your account using the provided credentials and start using our platform. </div><div><br></div><div>If you have any questions or need assistance, feel free to reach out to our support team. </div><div><br></div><div>Thank you for joining us! </div><div><br></div><div>Best regards, </div><div><b>{soft_name}</b></div><div><b></b></div>',
                'language_id' => getLanguageId('en'),
                'lang' => 'en',
                'type' => 'email',
                'group' => 'Agent',
                'status' => 'Active',
            ],
            ['name' => 'Notice for Agent Registration', 'alias' => 'notice-for-agent-registration', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ar'), 'lang' => 'ar', 'type' => 'email', 'group' => 'Agent', 'status' => 'Active'],
            ['name' => 'Notice for Agent Registration', 'alias' => 'notice-for-agent-registration', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('fr'), 'lang' => 'fr', 'type' => 'email', 'group' => 'Agent', 'status' => 'Active'],
            ['name' => 'Notice for Agent Registration', 'alias' => 'notice-for-agent-registration', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('pt'), 'lang' => 'pt', 'type' => 'email', 'group' => 'Agent', 'status' => 'Active'],
            ['name' => 'Notice for Agent Registration', 'alias' => 'notice-for-agent-registration', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ru'), 'lang' => 'ru', 'type' => 'email', 'group' => 'Agent', 'status' => 'Active'],
            ['name' => 'Notice for Agent Registration', 'alias' => 'notice-for-agent-registration', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('es'), 'lang' => 'es', 'type' => 'email', 'group' => 'Agent', 'status' => 'Active'],
            ['name' => 'Notice for Agent Registration', 'alias' => 'notice-for-agent-registration', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('tr'), 'lang' => 'tr', 'type' => 'email', 'group' => 'Agent', 'status' => 'Active'],
            ['name' => 'Notice for Agent Registration', 'alias' => 'notice-for-agent-registration', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ch'), 'lang' => 'ch', 'type' => 'email', 'group' => 'Agent', 'status' => 'Active'],

            // Agent deposit notification via Admin.
            [
                'name' => 'Agent deposit notification via Admin',
                'alias' => 'agent-deposit-notification-via-admin',
                'subject' => 'Agent deposit Notification',
                'body' => 'Hi <b>{agent}</b>,
                <br><br>A deposit has been successfully made to your account.
                <br><br><b><u><i>Here’s a brief overview of the deposit:</i></u></b>
                <br><br><b><u>deposit at:</u></b> {created_at}
                <br><br><b><u>deposit via:</u></b> {payment_method}
                <br><br><b><u>Transaction ID:</u></b> {uuid}
                <br><br><b><u>Currency:</u></b> {code}
                <br><br><b><u>Amount:</u></b> {amount}
                <br><br><b><u>Fee:</u></b> {fee}
                <br><br>If you have any questions, please feel free to reply to this email.
                <br><br>Regards,
                <br><b>{soft_name}</b>',
                'language_id' => getLanguageId('en'),
                'lang' => 'en',
                'type' => 'email',
                'group' => 'Agent',
                'status' => 'Active',
            ],
            ['name' => 'Agent deposit notification via Admin', 'alias' => 'agent-deposit-notification-via-admin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ar'), 'lang' => 'ar', 'type' => 'email', 'group' => 'Agent', 'status' => 'Active'],
            ['name' => 'Agent deposit notification via Admin', 'alias' => 'agent-deposit-notification-via-admin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('fr'), 'lang' => 'fr', 'type' => 'email', 'group' => 'Agent', 'status' => 'Active'],
            ['name' => 'Agent deposit notification via Admin', 'alias' => 'agent-deposit-notification-via-admin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('pt'), 'lang' => 'pt', 'type' => 'email', 'group' => 'Agent', 'status' => 'Active'],
            ['name' => 'Agent deposit notification via Admin', 'alias' => 'agent-deposit-notification-via-admin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ru'), 'lang' => 'ru', 'type' => 'email', 'group' => 'Agent', 'status' => 'Active'],
            ['name' => 'Agent deposit notification via Admin', 'alias' => 'agent-deposit-notification-via-admin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('es'), 'lang' => 'es', 'type' => 'email', 'group' => 'Agent', 'status' => 'Active'],
            ['name' => 'Agent deposit notification via Admin', 'alias' => 'agent-deposit-notification-via-admin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('tr'), 'lang' => 'tr', 'type' => 'email', 'group' => 'Agent', 'status' => 'Active'],
            ['name' => 'Agent deposit notification via Admin', 'alias' => 'agent-deposit-notification-via-admin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ch'), 'lang' => 'ch', 'type' => 'email', 'group' => 'Agent', 'status' => 'Active'],

            // Admin Notify on CashIn Transaction
            [
                'name' => 'Notify Admin on CashIn',
                'alias' => 'notify-admin-on-cashin',
                'subject' => 'Money Cashin Notification',
                'body' => 'Hi <b>{admin}</b>,
                    <br><br>Amount <b>{amount}</b> has been Cashin by <b>{user}</br>
                    <br><br><b><u><i>Here’s a brief overview of the Cashin:</i></u></b>
                    <br><br><b><u>Cashin at:</u></b> {created_at}
                    <br><br><b><u>Cashin via:</u></b> {payment_method}
                    <br><br><b><u>Transaction ID:</u></b> {uuid}
                    <br><br><b><u>Currency:</u></b> {code}
                    <br><br><b><u>Amount:</u></b> {amount}
                    <br><br><b><u>Fee:</u></b> {fee}
                    <br><br>If you have any questions, please feel free to reply to this email.
                    <br><br>Regards,
                    <br><b>{soft_name}</b>',
                'language_id' => getLanguageId('en'),
                'lang' => 'en',
                'type' => 'email',
                'group' => 'CashIn',
                'status' => 'Active',
            ],
            ['name' => 'Notify Admin on CashIn', 'alias' => 'notify-admin-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ar'), 'lang' => 'ar', 'type' => 'email', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify Admin on CashIn', 'alias' => 'notify-admin-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('fr'), 'lang' => 'fr', 'type' => 'email', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify Admin on CashIn', 'alias' => 'notify-admin-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('pt'), 'lang' => 'pt', 'type' => 'email', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify Admin on CashIn', 'alias' => 'notify-admin-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ru'), 'lang' => 'ru', 'type' => 'email', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify Admin on CashIn', 'alias' => 'notify-admin-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('es'), 'lang' => 'es', 'type' => 'email', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify Admin on CashIn', 'alias' => 'notify-admin-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('tr'), 'lang' => 'tr', 'type' => 'email', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify Admin on CashIn', 'alias' => 'notify-admin-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ch'), 'lang' => 'ch', 'type' => 'email', 'group' => 'CashIn', 'status' => 'Active'],

            // Agent Notify on CashIn Transaction
            [
                'name' => 'Notify Agent on CashIn',
                'alias' => 'notify-agent-on-cashin',
                'subject' => 'Money Cashin Notification',
                'body' => 'Hi <b>{agent}</b>,
                    <br><br>Amount <b>{amount}</b> has been Cashin by <b>{user}</br>
                    <br><br><b><u><i>Here’s a brief overview of the Cashin:</i></u></b>
                    <br><br><b><u>Cashin at:</u></b> {created_at}
                    <br><br><b><u>Cashin via:</u></b> {payment_method}
                    <br><br><b><u>Transaction ID:</u></b> {uuid}
                    <br><br><b><u>Currency:</u></b> {code}
                    <br><br><b><u>Amount:</u></b> {amount}
                    <br><br><b><u>Fee:</u></b> {fee}
                    <br><br>If you have any questions, please feel free to reply to this email.
                    <br><br>Regards,
                    <br><b>{soft_name}</b>',
                'language_id' => getLanguageId('en'),
                'lang' => 'en',
                'type' => 'email',
                'group' => 'CashIn',
                'status' => 'Active',
            ],
            ['name' => 'Notify Agent on CashIn', 'alias' => 'notify-agent-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ar'), 'lang' => 'ar', 'type' => 'email', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify Agent on CashIn', 'alias' => 'notify-agent-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('fr'), 'lang' => 'fr', 'type' => 'email', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify Agent on CashIn', 'alias' => 'notify-agent-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('pt'), 'lang' => 'pt', 'type' => 'email', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify Agent on CashIn', 'alias' => 'notify-agent-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ru'), 'lang' => 'ru', 'type' => 'email', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify Agent on CashIn', 'alias' => 'notify-agent-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('es'), 'lang' => 'es', 'type' => 'email', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify Agent on CashIn', 'alias' => 'notify-agent-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('tr'), 'lang' => 'tr', 'type' => 'email', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify Agent on CashIn', 'alias' => 'notify-agent-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ch'), 'lang' => 'ch', 'type' => 'email', 'group' => 'CashIn', 'status' => 'Active'],

            // User Notify on CashIn Transaction
            [
                'name' => 'Notify User on CashIn',
                'alias' => 'notify-user-on-cashin',
                'subject' => 'Money Cashin Notification',
                'body' => 'Hi <b>{user}</b>,
                    <br><br>Amount <b>{amount}</b> has been Cashin by <b>{user}</br>
                    <br><br><b><u><i>Here’s a brief overview of the Cashin:</i></u></b>
                    <br><br><b><u>Cashin at:</u></b> {created_at}
                    <br><br><b><u>Cashin via:</u></b> {payment_method}
                    <br><br><b><u>Transaction ID:</u></b> {uuid}
                    <br><br><b><u>Currency:</u></b> {code}
                    <br><br><b><u>Amount:</u></b> {amount}
                    <br><br><b><u>Fee:</u></b> {fee}
                    <br><br>If you have any questions, please feel free to reply to this email.
                    <br><br>Regards,
                    <br><b>{soft_name}</b>',
                'language_id' => getLanguageId('en'),
                'lang' => 'en',
                'type' => 'email',
                'group' => 'CashIn',
                'status' => 'Active',
            ],
            ['name' => 'Notify User on CashIn', 'alias' => 'notify-user-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ar'), 'lang' => 'ar', 'type' => 'email', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify User on CashIn', 'alias' => 'notify-user-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('fr'), 'lang' => 'fr', 'type' => 'email', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify User on CashIn', 'alias' => 'notify-user-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('pt'), 'lang' => 'pt', 'type' => 'email', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify User on CashIn', 'alias' => 'notify-user-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ru'), 'lang' => 'ru', 'type' => 'email', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify User on CashIn', 'alias' => 'notify-user-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('es'), 'lang' => 'es', 'type' => 'email', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify User on CashIn', 'alias' => 'notify-user-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('tr'), 'lang' => 'tr', 'type' => 'email', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify User on CashIn', 'alias' => 'notify-user-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ch'), 'lang' => 'ch', 'type' => 'email', 'group' => 'CashIn', 'status' => 'Active'],

            // Admin Notify on CashOut Transaction
            [
                'name' => 'Notify Admin on CashOut',
                'alias' => 'notify-admin-on-cashout',
                'subject' => 'Money CashOut Notification',
                'body' => 'Hi <b>{admin}</b>,
                    <br><br>Amount <b>{amount}</b> has been CashOut by <b>{user}</br>
                    <br><br><b><u><i>Here’s a brief overview of the CashOut:</i></u></b>
                    <br><br><b><u>CashOut at:</u></b> {created_at}
                    <br><br><b><u>CashOut via:</u></b> {payment_method}
                    <br><br><b><u>Transaction ID:</u></b> {uuid}
                    <br><br><b><u>Currency:</u></b> {code}
                    <br><br><b><u>Amount:</u></b> {amount}
                    <br><br><b><u>Fee:</u></b> {fee}
                    <br><br>If you have any questions, please feel free to reply to this email.
                    <br><br>Regards,
                    <br><b>{soft_name}</b>',
                'language_id' => getLanguageId('en'),
                'lang' => 'en',
                'type' => 'email',
                'group' => 'CashOut',
                'status' => 'Active',
            ],
            ['name' => 'Notify Admin on CashOut', 'alias' => 'notify-admin-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ar'), 'lang' => 'ar', 'type' => 'email', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify Admin on CashOut', 'alias' => 'notify-admin-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('fr'), 'lang' => 'fr', 'type' => 'email', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify Admin on CashOut', 'alias' => 'notify-admin-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('pt'), 'lang' => 'pt', 'type' => 'email', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify Admin on CashOut', 'alias' => 'notify-admin-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ru'), 'lang' => 'ru', 'type' => 'email', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify Admin on CashOut', 'alias' => 'notify-admin-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('es'), 'lang' => 'es', 'type' => 'email', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify Admin on CashOut', 'alias' => 'notify-admin-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('tr'), 'lang' => 'tr', 'type' => 'email', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify Admin on CashOut', 'alias' => 'notify-admin-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ch'), 'lang' => 'ch', 'type' => 'email', 'group' => 'CashOut', 'status' => 'Active'],

            // Agent Notify on CashOut Transaction
            [
                'name' => 'Notify Agent on CashOut',
                'alias' => 'notify-agent-on-cashout',
                'subject' => 'Money CashOut Notification',
                'body' => 'Hi <b>{agent}</b>,
                    <br><br>Amount <b>{amount}</b> has been CashOut from <b>{user}</br>
                    <br><br><b><u><i>Here’s a brief overview of the CashOut:</i></u></b>
                    <br><br><b><u>CashOut at:</u></b> {created_at}
                    <br><br><b><u>CashOut via:</u></b> {payment_method}
                    <br><br><b><u>Transaction ID:</u></b> {uuid}
                    <br><br><b><u>Currency:</u></b> {code}
                    <br><br><b><u>Amount:</u></b> {amount}
                    <br><br><b><u>Fee:</u></b> {fee}
                    <br><br>If you have any questions, please feel free to reply to this email.
                    <br><br>Regards,
                    <br><b>{soft_name}</b>',
                'language_id' => getLanguageId('en'),
                'lang' => 'en',
                'type' => 'email',
                'group' => 'CashOut',
                'status' => 'Active',
            ],
            ['name' => 'Notify Agent on CashOut', 'alias' => 'notify-agent-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ar'), 'lang' => 'ar', 'type' => 'email', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify Agent on CashOut', 'alias' => 'notify-agent-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('fr'), 'lang' => 'fr', 'type' => 'email', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify Agent on CashOut', 'alias' => 'notify-agent-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('pt'), 'lang' => 'pt', 'type' => 'email', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify Agent on CashOut', 'alias' => 'notify-agent-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ru'), 'lang' => 'ru', 'type' => 'email', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify Agent on CashOut', 'alias' => 'notify-agent-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('es'), 'lang' => 'es', 'type' => 'email', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify Agent on CashOut', 'alias' => 'notify-agent-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('tr'), 'lang' => 'tr', 'type' => 'email', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify Agent on CashOut', 'alias' => 'notify-agent-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ch'), 'lang' => 'ch', 'type' => 'email', 'group' => 'CashOut', 'status' => 'Active'],

            // User Notify on CashOut Transaction
            [
                'name' => 'Notify User on CashOut',
                'alias' => 'notify-user-on-cashout',
                'subject' => 'Money CashOut Notification',
                'body' => 'Hi <b>{user}</b>,
                    <br><br>Amount <b>{amount}</b> has been CashOut by <b>{user}</br>
                    <br><br><b><u><i>Here’s a brief overview of the CashOut:</i></u></b>
                    <br><br><b><u>CashOut at:</u></b> {created_at}
                    <br><br><b><u>CashOut via:</u></b> {payment_method}
                    <br><br><b><u>Transaction ID:</u></b> {uuid}
                    <br><br><b><u>Currency:</u></b> {code}
                    <br><br><b><u>Amount:</u></b> {amount}
                    <br><br><b><u>Fee:</u></b> {fee}
                    <br><br>If you have any questions, please feel free to reply to this email.
                    <br><br>Regards,
                    <br><b>{soft_name}</b>',
                'language_id' => getLanguageId('en'),
                'lang' => 'en',
                'type' => 'email',
                'group' => 'CashOut',
                'status' => 'Active',
            ],
            ['name' => 'Notify User on CashOut', 'alias' => 'notify-user-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ar'), 'lang' => 'ar', 'type' => 'email', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify User on CashOut', 'alias' => 'notify-user-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('fr'), 'lang' => 'fr', 'type' => 'email', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify User on CashOut', 'alias' => 'notify-user-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('pt'), 'lang' => 'pt', 'type' => 'email', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify User on CashOut', 'alias' => 'notify-user-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ru'), 'lang' => 'ru', 'type' => 'email', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify User on CashOut', 'alias' => 'notify-user-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('es'), 'lang' => 'es', 'type' => 'email', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify User on CashOut', 'alias' => 'notify-user-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('tr'), 'lang' => 'tr', 'type' => 'email', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify User on CashOut', 'alias' => 'notify-user-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ch'), 'lang' => 'ch', 'type' => 'email', 'group' => 'CashOut', 'status' => 'Active'],

            // Agent Cashout OTP code verification
            [
                'name' => 'Agent Cashout OTP code verification',
                'alias' => 'agent-cashout-otp-code-verification',
                'subject' => 'Agent Cashout OTP code verification',
                'body' => 'Hi <b>{user}</b>,<div><br></div><div>Please use the following OTP code to verify your cash-out request:</div><div><br></div><div>OTP Code: <b>{otp_code}</b></div><div><br></div><div>Thank you for using our services.</div><div><br></div><div>Best regards,<br><b>{soft_name}</b></div>',
                'language_id' => getLanguageId('en'),
                'lang' => 'en',
                'type' => 'email',
                'group' => 'CashOut',
                'status' => 'Active',
            ],
            ['name' => 'Agent Cashout OTP code verification', 'alias' => 'agent-cashout-otp-code-verification', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ar'), 'lang' => 'ar', 'type' => 'email', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Agent Cashout OTP code verification', 'alias' => 'agent-cashout-otp-code-verification', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('fr'), 'lang' => 'fr', 'type' => 'email', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Agent Cashout OTP code verification', 'alias' => 'agent-cashout-otp-code-verification', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('pt'), 'lang' => 'pt', 'type' => 'email', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Agent Cashout OTP code verification', 'alias' => 'agent-cashout-otp-code-verification', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ru'), 'lang' => 'ru', 'type' => 'email', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Agent Cashout OTP code verification', 'alias' => 'agent-cashout-otp-code-verification', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('es'), 'lang' => 'es', 'type' => 'email', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Agent Cashout OTP code verification', 'alias' => 'agent-cashout-otp-code-verification', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('tr'), 'lang' => 'tr', 'type' => 'email', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Agent Cashout OTP code verification', 'alias' => 'agent-cashout-otp-code-verification', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ch'), 'lang' => 'ch', 'type' => 'email', 'group' => 'CashOut', 'status' => 'Active'],

            // Notice for Agent Registration
            [
                'name' => 'Notice for Agent Registration',
                'alias' => 'notice-for-agent-registration',
                'subject' => 'Notice for Agent Registration',
                'body' => 'Hi <b>{agent}</b>, Congratulations! You have been successfully registered as an agent by our admin. Your Account Details: Name: <b>{agent},&nbsp;</b>Email: <b>{email},&nbsp;</b>Password: <b>{password}.&nbsp;</b>Thank you for joining us. Best regards,<b>{soft_name}</b><div><b></b></div>',
                'language_id' => getLanguageId('en'),
                'lang' => 'en',
                'type' => 'sms',
                'group' => 'Agent',
                'status' => 'Active',
            ],
            ['name' => 'Notice for Agent Registration', 'alias' => 'notice-for-agent-registration', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ar'), 'lang' => 'ar', 'type' => 'sms', 'group' => 'Agent', 'status' => 'Active'],
            ['name' => 'Notice for Agent Registration', 'alias' => 'notice-for-agent-registration', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('fr'), 'lang' => 'fr', 'type' => 'sms', 'group' => 'Agent', 'status' => 'Active'],
            ['name' => 'Notice for Agent Registration', 'alias' => 'notice-for-agent-registration', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('pt'), 'lang' => 'pt', 'type' => 'sms', 'group' => 'Agent', 'status' => 'Active'],
            ['name' => 'Notice for Agent Registration', 'alias' => 'notice-for-agent-registration', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ru'), 'lang' => 'ru', 'type' => 'sms', 'group' => 'Agent', 'status' => 'Active'],
            ['name' => 'Notice for Agent Registration', 'alias' => 'notice-for-agent-registration', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('es'), 'lang' => 'es', 'type' => 'sms', 'group' => 'Agent', 'status' => 'Active'],
            ['name' => 'Notice for Agent Registration', 'alias' => 'notice-for-agent-registration', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('tr'), 'lang' => 'tr', 'type' => 'sms', 'group' => 'Agent', 'status' => 'Active'],
            ['name' => 'Notice for Agent Registration', 'alias' => 'notice-for-agent-registration', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ch'), 'lang' => 'ch', 'type' => 'sms', 'group' => 'Agent', 'status' => 'Active'],

            // Agent deposit notification via Admin.
            [
                'name' => 'Agent deposit notification via Admin',
                'alias' => 'agent-deposit-notification-via-admin',
                'subject' => 'Agent deposit Notification',
                'body' => 'Hi {agent}, an amount of {amount} has been deposited to your account by the admin. Thank you for your service. Best regards,<b>{soft_name}</b>',
                'language_id' => getLanguageId('en'),
                'lang' => 'en',
                'type' => 'sms',
                'group' => 'Agent',
                'status' => 'Active',
            ],
            ['name' => 'Agent deposit notification via Admin', 'alias' => 'agent-deposit-notification-via-admin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ar'), 'lang' => 'ar', 'type' => 'sms', 'group' => 'Agent', 'status' => 'Active'],
            ['name' => 'Agent deposit notification via Admin', 'alias' => 'agent-deposit-notification-via-admin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('fr'), 'lang' => 'fr', 'type' => 'sms', 'group' => 'Agent', 'status' => 'Active'],
            ['name' => 'Agent deposit notification via Admin', 'alias' => 'agent-deposit-notification-via-admin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('pt'), 'lang' => 'pt', 'type' => 'sms', 'group' => 'Agent', 'status' => 'Active'],
            ['name' => 'Agent deposit notification via Admin', 'alias' => 'agent-deposit-notification-via-admin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ru'), 'lang' => 'ru', 'type' => 'sms', 'group' => 'Agent', 'status' => 'Active'],
            ['name' => 'Agent deposit notification via Admin', 'alias' => 'agent-deposit-notification-via-admin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('es'), 'lang' => 'es', 'type' => 'sms', 'group' => 'Agent', 'status' => 'Active'],
            ['name' => 'Agent deposit notification via Admin', 'alias' => 'agent-deposit-notification-via-admin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('tr'), 'lang' => 'tr', 'type' => 'sms', 'group' => 'Agent', 'status' => 'Active'],
            ['name' => 'Agent deposit notification via Admin', 'alias' => 'agent-deposit-notification-via-admin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ch'), 'lang' => 'ch', 'type' => 'sms', 'group' => 'Agent', 'status' => 'Active'],

            // Admin Notify on CashIn Transaction
            [
                'name' => 'Notify Admin on CashIn',
                'alias' => 'notify-admin-on-cashin',
                'subject' => 'Money Cashin Notification',
                'body' => 'Hi {admin}, a cash deposit of {amount} has been made by {agent} for {user}. Best regards,<b>{soft_name}</b>',
                'language_id' => getLanguageId('en'),
                'lang' => 'en',
                'type' => 'sms',
                'group' => 'CashIn',
                'status' => 'Active',
            ],
            ['name' => 'Notify Admin on CashIn', 'alias' => 'notify-admin-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ar'), 'lang' => 'ar', 'type' => 'sms', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify Admin on CashIn', 'alias' => 'notify-admin-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('fr'), 'lang' => 'fr', 'type' => 'sms', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify Admin on CashIn', 'alias' => 'notify-admin-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('pt'), 'lang' => 'pt', 'type' => 'sms', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify Admin on CashIn', 'alias' => 'notify-admin-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ru'), 'lang' => 'ru', 'type' => 'sms', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify Admin on CashIn', 'alias' => 'notify-admin-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('es'), 'lang' => 'es', 'type' => 'sms', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify Admin on CashIn', 'alias' => 'notify-admin-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('tr'), 'lang' => 'tr', 'type' => 'sms', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify Admin on CashIn', 'alias' => 'notify-admin-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ch'), 'lang' => 'ch', 'type' => 'sms', 'group' => 'CashIn', 'status' => 'Active'],

            // Agent Notify on CashIn Transaction
            [
                'name' => 'Notify Agent on CashIn',
                'alias' => 'notify-agent-on-cashin',
                'subject' => 'Money Cashin Notification',
                'body' => 'Hi {agent}, a cash deposit of {amount} has been successfully made to the account of {user}. Best regards,<b>{soft_name}</b>\r\n\r\n<br>',
                'language_id' => getLanguageId('en'),
                'lang' => 'en',
                'type' => 'sms',
                'group' => 'CashIn',
                'status' => 'Active',
            ],
            ['name' => 'Notify Agent on CashIn', 'alias' => 'notify-agent-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ar'), 'lang' => 'ar', 'type' => 'sms', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify Agent on CashIn', 'alias' => 'notify-agent-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('fr'), 'lang' => 'fr', 'type' => 'sms', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify Agent on CashIn', 'alias' => 'notify-agent-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('pt'), 'lang' => 'pt', 'type' => 'sms', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify Agent on CashIn', 'alias' => 'notify-agent-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ru'), 'lang' => 'ru', 'type' => 'sms', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify Agent on CashIn', 'alias' => 'notify-agent-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('es'), 'lang' => 'es', 'type' => 'sms', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify Agent on CashIn', 'alias' => 'notify-agent-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('tr'), 'lang' => 'tr', 'type' => 'sms', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify Agent on CashIn', 'alias' => 'notify-agent-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ch'), 'lang' => 'ch', 'type' => 'sms', 'group' => 'CashIn', 'status' => 'Active'],

            // User Notify on CashIn Transaction
            [
                'name' => 'Notify User on CashIn',
                'alias' => 'notify-user-on-cashin',
                'subject' => 'Money Cashin Notification',
                'body' => 'Hi {user}, a cash deposit of {amount} has been successfully made to your account. Thank you for using our service.&nbsp;Best regards,<b>{soft_name}</b>\r\n\r\n<b><b></b></b>',
                'language_id' => getLanguageId('en'),
                'lang' => 'en',
                'type' => 'sms',
                'group' => 'CashIn',
                'status' => 'Active',
            ],
            ['name' => 'Notify User on CashIn', 'alias' => 'notify-user-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ar'), 'lang' => 'ar', 'type' => 'sms', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify User on CashIn', 'alias' => 'notify-user-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('fr'), 'lang' => 'fr', 'type' => 'sms', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify User on CashIn', 'alias' => 'notify-user-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('pt'), 'lang' => 'pt', 'type' => 'sms', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify User on CashIn', 'alias' => 'notify-user-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ru'), 'lang' => 'ru', 'type' => 'sms', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify User on CashIn', 'alias' => 'notify-user-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('es'), 'lang' => 'es', 'type' => 'sms', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify User on CashIn', 'alias' => 'notify-user-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('tr'), 'lang' => 'tr', 'type' => 'sms', 'group' => 'CashIn', 'status' => 'Active'],
            ['name' => 'Notify User on CashIn', 'alias' => 'notify-user-on-cashin', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ch'), 'lang' => 'ch', 'type' => 'sms', 'group' => 'CashIn', 'status' => 'Active'],

            // Admin Notify on CashOut Transaction
            [
                'name' => 'Notify Admin on CashOut',
                'alias' => 'notify-admin-on-cashout',
                'subject' => 'Money CashOut Notification',
                'body' => 'Hi {admin}, {user} has initiated a cash out of {amount}.<div>Best regards,<b>{soft_name}</b></div>',
                'language_id' => getLanguageId('en'),
                'lang' => 'en',
                'type' => 'sms',
                'group' => 'CashOut',
                'status' => 'Active',
            ],
            ['name' => 'Notify Admin on CashOut', 'alias' => 'notify-admin-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ar'), 'lang' => 'ar', 'type' => 'sms', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify Admin on CashOut', 'alias' => 'notify-admin-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('fr'), 'lang' => 'fr', 'type' => 'sms', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify Admin on CashOut', 'alias' => 'notify-admin-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('pt'), 'lang' => 'pt', 'type' => 'sms', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify Admin on CashOut', 'alias' => 'notify-admin-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ru'), 'lang' => 'ru', 'type' => 'sms', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify Admin on CashOut', 'alias' => 'notify-admin-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('es'), 'lang' => 'es', 'type' => 'sms', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify Admin on CashOut', 'alias' => 'notify-admin-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('tr'), 'lang' => 'tr', 'type' => 'sms', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify Admin on CashOut', 'alias' => 'notify-admin-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ch'), 'lang' => 'ch', 'type' => 'sms', 'group' => 'CashOut', 'status' => 'Active'],

            // Agent Notify on CashOut Transaction
            [
                'name' => 'Notify Agent on CashOut',
                'alias' => 'notify-agent-on-cashout',
                'subject' => 'Money CashOut Notification',
                'body' => 'Hi {agent}, a cash out request of {amount} has been initiated from your account. If you did not initiate this request, please contact support immediately.<div>Best regards,<b>{soft_name}</b></div>',
                'language_id' => getLanguageId('en'),
                'lang' => 'en',
                'type' => 'sms',
                'group' => 'CashOut',
                'status' => 'Active',
            ],
            ['name' => 'Notify Agent on CashOut', 'alias' => 'notify-agent-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ar'), 'lang' => 'ar', 'type' => 'sms', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify Agent on CashOut', 'alias' => 'notify-agent-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('fr'), 'lang' => 'fr', 'type' => 'sms', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify Agent on CashOut', 'alias' => 'notify-agent-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('pt'), 'lang' => 'pt', 'type' => 'sms', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify Agent on CashOut', 'alias' => 'notify-agent-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ru'), 'lang' => 'ru', 'type' => 'sms', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify Agent on CashOut', 'alias' => 'notify-agent-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('es'), 'lang' => 'es', 'type' => 'sms', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify Agent on CashOut', 'alias' => 'notify-agent-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('tr'), 'lang' => 'tr', 'type' => 'sms', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify Agent on CashOut', 'alias' => 'notify-agent-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ch'), 'lang' => 'ch', 'type' => 'sms', 'group' => 'CashOut', 'status' => 'Active'],

            // User Notify on CashOut Transaction
            [
                'name' => 'Notify User on CashOut',
                'alias' => 'notify-user-on-cashout',
                'subject' => 'Money CashOut Notification',
                'body' => 'Hi {user}, your cash out request of {amount} has been processed. Please allow some time for the transaction.<div>Best regards,<b>{soft_name}</b></div>',
                'language_id' => getLanguageId('en'),
                'lang' => 'en',
                'type' => 'sms',
                'group' => 'CashOut',
                'status' => 'Active',
            ],
            ['name' => 'Notify User on CashOut', 'alias' => 'notify-user-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ar'), 'lang' => 'ar', 'type' => 'sms', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify User on CashOut', 'alias' => 'notify-user-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('fr'), 'lang' => 'fr', 'type' => 'sms', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify User on CashOut', 'alias' => 'notify-user-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('pt'), 'lang' => 'pt', 'type' => 'sms', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify User on CashOut', 'alias' => 'notify-user-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ru'), 'lang' => 'ru', 'type' => 'sms', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify User on CashOut', 'alias' => 'notify-user-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('es'), 'lang' => 'es', 'type' => 'sms', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify User on CashOut', 'alias' => 'notify-user-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('tr'), 'lang' => 'tr', 'type' => 'sms', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Notify User on CashOut', 'alias' => 'notify-user-on-cashout', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ch'), 'lang' => 'ch', 'type' => 'sms', 'group' => 'CashOut', 'status' => 'Active'],

            // Agent Cashout OTP code verification
            [
                'name' => 'Agent Cashout OTP code verification',
                'alias' => 'agent-cashout-otp-code-verification',
                'subject' => 'Agent Cashout OTP code verification',
                'body' => 'Hi {user}, use the OTP code {otp_code} to verify your cash out request.<div>Best regards,<b>{soft_name}</b></div>',
                'language_id' => getLanguageId('en'),
                'lang' => 'en',
                'type' => 'sms',
                'group' => 'CashOut',
                'status' => 'Active',
            ],
            ['name' => 'Agent Cashout OTP code verification', 'alias' => 'agent-cashout-otp-code-verification', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ar'), 'lang' => 'ar', 'type' => 'sms', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Agent Cashout OTP code verification', 'alias' => 'agent-cashout-otp-code-verification', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('fr'), 'lang' => 'fr', 'type' => 'sms', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Agent Cashout OTP code verification', 'alias' => 'agent-cashout-otp-code-verification', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('pt'), 'lang' => 'pt', 'type' => 'sms', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Agent Cashout OTP code verification', 'alias' => 'agent-cashout-otp-code-verification', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ru'), 'lang' => 'ru', 'type' => 'sms', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Agent Cashout OTP code verification', 'alias' => 'agent-cashout-otp-code-verification', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('es'), 'lang' => 'es', 'type' => 'sms', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Agent Cashout OTP code verification', 'alias' => 'agent-cashout-otp-code-verification', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('tr'), 'lang' => 'tr', 'type' => 'sms', 'group' => 'CashOut', 'status' => 'Active'],
            ['name' => 'Agent Cashout OTP code verification', 'alias' => 'agent-cashout-otp-code-verification', 'subject' => '', 'body' => '', 'language_id' => getLanguageId('ch'), 'lang' => 'ch', 'type' => 'sms', 'group' => 'CashOut', 'status' => 'Active'],
        ]);
    }
}
