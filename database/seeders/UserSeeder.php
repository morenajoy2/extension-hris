<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\DepartmentTeam;
use App\Models\EmploymentType;
use App\Models\Group;
use App\Models\Position;
use App\Models\Role;
use App\Models\Strand;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Roles
        $adminRoleId = Role::where('role', 'Admin')->first()?->id;
        $teamLeaderRoleId = Role::where('role', 'Team Leader')->first()?->id;
        $groupLeaderRoleId = Role::where('role', 'Group Leader')->first()?->id;
        $memberRoleId = Role::where('role', 'Member')->first()?->id;

        //Employment Types
        $k12Id = EmploymentType::where('type_name', 'K-12 Work Immersion')->first()?->id;
        $collegeInternId = EmploymentType::where('type_name', 'College Internship')->first()?->id;
        $gradApprenticeId = EmploymentType::where('type_name', 'Graduate Apprenticeship')->first()?->id;
        $partTimeID = EmploymentType::where('type_name', 'Part-Time Job')->first()?->id;
        $fullTimeID = EmploymentType::where('type_name', 'Full-Time Job')->first()?->id;

        //Departments
        $managementDeptId = Department::where('department_name', 'Management')->first()?->id;
        $digitalOpsDeptId = Department::where('department_name', 'Digital Operations')->first()?->id;

        //Department Teams
        $corpServicesTeamId = DepartmentTeam::where('team_name', 'Corporate Services')->first()?->id;
        $webDevTeamId = DepartmentTeam::where('team_name', 'Web & Mobile Development')->first()?->id;
        $cliServicesTeamId = DepartmentTeam::where('team_name', 'Client Services')->first()?->id;
        $creMultimediaTeamId = DepartmentTeam::where('team_name', 'Creative Multimedia')->first()?->id;

        //Positions
        $frontWebId = Position::where('position_name', 'Front-End Web & Mobile Development')->first()?->id;
        $backWebId = Position::where('position_name', 'Back-End Web & Mobile Development')->first()?->id;
        $multimediaId = Position::where('position_name', 'Creative Multimedia')->first()?->id;
        $aiPosId = Position::where('position_name', 'AI Automation')->first()?->id;
        $grapDesignId = Position::where('position_name', 'Graphic Design')->first()?->id;
        $copywriterId = Position::where('position_name', 'Copywriter')->first()?->id;
        $hrId = Position::where('position_name', 'HR')->first()?->id;
        $financeId = Position::where('position_name', 'Finance')->first()?->id;
        $accountingId = Position::where('position_name', 'Accounting')->first()?->id;
        $pmPosId = Position::where('position_name', 'Project Management')->first()?->id;
        $salesId = Position::where('position_name', 'Sales')->first()?->id;
        $marketId = Position::where('position_name', 'Marketing')->first()?->id;
        $accountsId = Position::where('position_name', 'Accounts')->first()?->id;
        $bsDevId = Position::where('position_name', 'Business Development')->first()?->id;

        //Strands
        $stemStrandId = Strand::where('strand_name', 'STEM')->first()?->id;
        $humssStrandId = Strand::where('strand_name', 'HUMSS')->first()?->id;
        $gasStrandId = Strand::where('strand_name', 'GAS')->first()?->id;
        $aniStrandId = Strand::where('strand_name', 'ICT-Animation')->first()?->id;
        $progStrandId = Strand::where('strand_name', 'ICT-Programming')->first()?->id;

        //Groups
        $group1Id = Group::where('group_no', 1)->first()?->id;
        $group2Id = Group::where('group_no', 2)->first()?->id;
        $group3Id = Group::where('group_no', 3)->first()?->id;
        $group4Id = Group::where('group_no', 4)->first()?->id;


        //Admin
        User::create([
            'employee_id' => 1001,
            'first_name' => 'Marie',
            'last_name' => 'Santos',
            'role_id' => $adminRoleId,
            'status' => 'Active',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        //HR
        User::create([
            'employee_id' => 4038,
            'first_name' => 'Howl',
            'last_name' => 'Figueroa',
            'birth_of_date' => '2004-04-14',
            'school' => 'PUP Manila',
            'employment_type_id' => $collegeInternId,
            'role_id' => $groupLeaderRoleId,
            'department_id' => $managementDeptId,
            'department_team_id' => $corpServicesTeamId,
            'position_id' => $hrId,
            'status' => 'Active',
            'contact_number' => '09175559988',
            'gender' => 'Male',
            'email' => 'howl.figueroa@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group1Id,
        ]);

        User::create([
            'employee_id' => 4025,
            'first_name' => 'Zeke',
            'last_name' => 'Buenavista',
            'birth_of_date' => '2002-08-14',
            'school' => 'PUP Manila',
            'employment_type_id' => $collegeInternId,
            'role_id' => $memberRoleId,
            'department_id' => $managementDeptId,
            'department_team_id' => $corpServicesTeamId,
            'position_id' => $hrId,
            'status' => 'Active',
            'contact_number' => '09175559988',
            'gender' => 'Male',
            'email' => 'zeke.buenavista@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group1Id,
        ]);

        //Team Leader
        User::create([
            'employee_id' => 1002,
            'first_name' => 'Mark',
            'last_name' => 'Reyes',
            'birth_of_date' => '1998-05-01',
            'school' => 'FEU',
            'employment_type_id' => $gradApprenticeId,
            'role_id' => $teamLeaderRoleId,
            'department_id' => $managementDeptId,
            'department_team_id' => $corpServicesTeamId,
            'status' => 'Active',
            'contact_number' => '09120000001',
            'gender' => 'Male',
            'email' => 'markreyes@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'employee_id' => 2001,
            'first_name' => 'Juan',
            'last_name' => 'Dela Cruz',
            'birth_of_date' => '2000-01-01',
            'school' => 'UST',
            'employment_type_id' => $collegeInternId,
            'role_id' => $teamLeaderRoleId,
            'department_id' => $digitalOpsDeptId,
            'department_team_id' => $webDevTeamId,
            'status' => 'Active',
            'contact_number' => '09998887777',
            'gender' => 'Male',
            'email' => 'juandelacruz@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'employee_id' => 2002,
            'first_name' => 'Maria',
            'last_name' => 'Lopez',
            'birth_of_date' => '2001-03-03',
            'school' => 'DLSU',
            'employment_type_id' => $gradApprenticeId,
            'role_id' => $teamLeaderRoleId,
            'department_id' => $managementDeptId,
            'department_team_id' => $cliServicesTeamId,
            'status' => 'Active',
            'contact_number' => '09887776655',
            'gender' => 'Female',
            'email' => 'maria.lopez@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'employee_id' => 3001,
            'first_name' => 'Leo',
            'last_name' => 'Garcia',
            'birth_of_date' => '2001-12-12',
            'school' => 'NU',
            'employment_type_id' => $collegeInternId,
            'role_id' => $teamLeaderRoleId,
            'department_id' => $digitalOpsDeptId,
            'department_team_id' => $creMultimediaTeamId,
            'status' => 'Active',
            'contact_number' => '09111112222',
            'gender' => 'Male',
            'email' => 'group1@example.com',
            'password' => Hash::make('password'),
        ]);

        //Group Leader
        User::create([
            'employee_id' => 4005,
            'first_name' => 'Bryan',
            'last_name' => 'Santos',
            'birth_of_date' => '2000-06-10',
            'school' => 'TIP',
            'employment_type_id' => $gradApprenticeId,
            'role_id' => $groupLeaderRoleId,
            'department_id' => $digitalOpsDeptId,
            'department_team_id' => $webDevTeamId,
            'position_id' => $backWebId,
            'status' => 'Active',
            'contact_number' => '09221118899',
            'gender' => 'Male',
            'email' => 'bryan.santos@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group1Id,
        ]);

        User::create([
            'employee_id' => 4009,
            'first_name' => 'Miguel',
            'last_name' => 'Santiago',
            'birth_of_date' => '2002-02-25',
            'school' => 'FEU Tech',
            'employment_type_id' => $collegeInternId,
            'role_id' => $groupLeaderRoleId,
            'department_id' => $managementDeptId,
            'department_team_id' => $corpServicesTeamId,
            'position_id' => $pmPosId,
            'status' => 'Active',
            'contact_number' => '09229998811',
            'gender' => 'Male',
            'email' => 'miguel.santiago@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group1Id,
        ]);

        User::create([
            'employee_id' => 4033,
            'first_name' => 'Stella',
            'last_name' => 'Rodriguez',
            'birth_of_date' => '2004-04-14',
            'school' => 'PUP Manila',
            'employment_type_id' => $collegeInternId,
            'role_id' => $groupLeaderRoleId,
            'department_id' => $digitalOpsDeptId,
            'department_team_id' => $webDevTeamId,
            'position_id' => $aiPosId,
            'status' => 'Active',
            'contact_number' => '09175559988',
            'gender' => 'Female',
            'email' => 'stella.rodriguez@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group1Id,
        ]);

        User::create([
            'employee_id' => 4034,
            'first_name' => 'Divine',
            'last_name' => 'Realonda',
            'birth_of_date' => '2004-04-14',
            'school' => 'PUP Manila',
            'employment_type_id' => $collegeInternId,
            'role_id' => $groupLeaderRoleId,
            'department_id' => $digitalOpsDeptId,
            'department_team_id' => $webDevTeamId,
            'position_id' => $frontWebId,
            'status' => 'Active',
            'contact_number' => '09175559988',
            'gender' => 'Female',
            'email' => 'divine.realonda@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group2Id,
        ]);

        User::create([
            'employee_id' => 4035,
            'first_name' => 'Heart',
            'last_name' => 'Martin',
            'birth_of_date' => '2004-04-14',
            'school' => 'PUP Manila',
            'employment_type_id' => $collegeInternId,
            'role_id' => $groupLeaderRoleId,
            'department_id' => $digitalOpsDeptId,
            'department_team_id' => $creMultimediaTeamId,
            'position_id' => $multimediaId,
            'status' => 'Active',
            'contact_number' => '09175559988',
            'gender' => 'Female',
            'email' => 'heart.martin@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group2Id,
        ]);

        User::create([
            'employee_id' => 4036,
            'first_name' => 'Aoife',
            'last_name' => 'Felicano',
            'birth_of_date' => '2004-04-14',
            'school' => 'PUP Manila',
            'employment_type_id' => $collegeInternId,
            'role_id' => $groupLeaderRoleId,
            'department_id' => $digitalOpsDeptId,
            'department_team_id' => $creMultimediaTeamId,
            'position_id' => $grapDesignId,
            'status' => 'Active',
            'contact_number' => '09175559988',
            'gender' => 'Female',
            'email' => 'aiofe.felicano@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group2Id,
        ]);

        User::create([
            'employee_id' => 4037,
            'first_name' => 'Cassius',
            'last_name' => 'Figueroa',
            'birth_of_date' => '2004-04-14',
            'school' => 'PUP Manila',
            'employment_type_id' => $collegeInternId,
            'role_id' => $groupLeaderRoleId,
            'department_id' => $digitalOpsDeptId,
            'department_team_id' => $creMultimediaTeamId,
            'position_id' => $copywriterId,
            'status' => 'Active',
            'contact_number' => '09175559988',
            'gender' => 'Male',
            'email' => 'cassius.figueroa@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group2Id,
        ]);

        

        User::create([
            'employee_id' => 4039,
            'first_name' => 'Leese',
            'last_name' => 'Figueroa',
            'birth_of_date' => '2004-04-14',
            'school' => 'PUP Manila',
            'employment_type_id' => $collegeInternId,
            'role_id' => $groupLeaderRoleId,
            'department_id' => $managementDeptId,
            'department_team_id' => $corpServicesTeamId,
            'position_id' => $financeId,
            'status' => 'Active',
            'contact_number' => '09175559988',
            'gender' => 'Male',
            'email' => 'leese.figueroa@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group3Id,
        ]);

        User::create([
            'employee_id' => 4040,
            'first_name' => 'Fidai',
            'last_name' => 'Figueroa',
            'birth_of_date' => '2004-04-14',
            'school' => 'PUP Manila',
            'employment_type_id' => $collegeInternId,
            'role_id' => $groupLeaderRoleId,
            'department_id' => $managementDeptId,
            'department_team_id' => $corpServicesTeamId,
            'position_id' => $accountingId,
            'status' => 'Active',
            'contact_number' => '09175559988',
            'gender' => 'Male',
            'email' => 'fidai.figueroa@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group3Id,
        ]);

        User::create([
            'employee_id' => 4041,
            'first_name' => 'Kalix',
            'last_name' => 'Martinez',
            'birth_of_date' => '2004-04-14',
            'school' => 'PUP Manila',
            'employment_type_id' => $collegeInternId,
            'role_id' => $groupLeaderRoleId,
            'department_id' => $managementDeptId,
            'department_team_id' => $cliServicesTeamId,
            'position_id' => $salesId,
            'status' => 'Active',
            'contact_number' => '09175559988',
            'gender' => 'Male',
            'email' => 'kalix.martinez@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group3Id,
        ]);

        User::create([
            'employee_id' => 4042,
            'first_name' => 'Hiro',
            'last_name' => 'Juarez',
            'birth_of_date' => '2004-04-14',
            'school' => 'PUP Manila',
            'employment_type_id' => $collegeInternId,
            'role_id' => $groupLeaderRoleId,
            'department_id' => $managementDeptId,
            'department_team_id' => $cliServicesTeamId,
            'position_id' => $marketId,
            'status' => 'Active',
            'contact_number' => '09175559988',
            'gender' => 'Male',
            'email' => 'hiro.juarez@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group4Id,
        ]);

        User::create([
            'employee_id' => 4043,
            'first_name' => 'Luna',
            'last_name' => 'Valeria',
            'birth_of_date' => '2004-04-14',
            'school' => 'PUP Manila',
            'employment_type_id' => $collegeInternId,
            'role_id' => $groupLeaderRoleId,
            'department_id' => $managementDeptId,
            'department_team_id' => $cliServicesTeamId,
            'position_id' => $accountsId,
            'status' => 'Active',
            'contact_number' => '09175559988',
            'gender' => 'Female',
            'email' => 'luna.valeria@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group4Id,
        ]);

        User::create([
            'employee_id' => 4044,
            'first_name' => 'Yanna',
            'last_name' => 'Fernandez',
            'birth_of_date' => '2004-04-14',
            'school' => 'PUP Manila',
            'employment_type_id' => $collegeInternId,
            'role_id' => $groupLeaderRoleId,
            'department_id' => $managementDeptId,
            'department_team_id' => $cliServicesTeamId,
            'position_id' => $bsDevId,
            'status' => 'Active',
            'contact_number' => '09175559988',
            'gender' => 'Female',
            'email' => 'yanna.fernandez@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group4Id,
        ]);







        User::create([
            'employee_id' => 3002,
            'first_name' => 'Anna',
            'last_name' => 'Torres',
            'birth_of_date' => '2002-09-15',
            'school' => 'PUP',
            'employment_type_id' => $k12Id,
            'role_id' => $memberRoleId,
            'strand_id' => $stemStrandId,
            'department_id' => $digitalOpsDeptId,
            'department_team_id' => $webDevTeamId,
            'position_id' => $aiPosId,
            'status' => 'Active',
            'contact_number' => '09223334444',
            'gender' => 'Female',
            'email' => 'group2@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group1Id,
            
        ]);

        User::create([
            'employee_id' => 4001,
            'first_name' => 'John',
            'last_name' => 'Smith',
            'birth_of_date' => '2003-07-07',
            'school' => 'Adamson University',
            'employment_type_id' => $collegeInternId,
            'role_id' => $memberRoleId,
            'department_id' => $digitalOpsDeptId,
            'department_team_id' => $webDevTeamId,
            'position_id' => $backWebId,
            'status' => 'Active',
            'contact_number' => '09776665544',
            'gender' => 'Male',
            'email' => 'member1@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group1Id,
        ]);

        User::create([
            'employee_id' => 4002,
            'first_name' => 'Elaine',
            'last_name' => 'Rivera',
            'birth_of_date' => '2004-10-10',
            'school' => 'Lyceum',
            'employment_type_id' => $k12Id,
            'role_id' => $memberRoleId,
            'strand_id' => $humssStrandId,
            'department_id' => $digitalOpsDeptId,
            'department_team_id' => $creMultimediaTeamId,
            'position_id' => $copywriterId,
            'status' => 'Exited',
            'contact_number' => '09667778899',
            'gender' => 'Female',
            'email' => 'member2@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group1Id,
        ]);

        User::create([
            'employee_id' => 4003,
            'first_name' => 'Kevin',
            'last_name' => 'Tan',
            'birth_of_date' => '2003-02-20',
            'school' => 'UE Manila',
            'employment_type_id' => $collegeInternId,
            'role_id' => $memberRoleId,
            'department_id' => $digitalOpsDeptId,
            'department_team_id' => $creMultimediaTeamId,
            'position_id' => $multimediaId,
            'status' => 'Active',
            'contact_number' => '09178889900',
            'gender' => 'Male',
            'email' => 'kevin.tan@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group1Id,
        ]);

        User::create([
            'employee_id' => 4004,
            'first_name' => 'Samantha',
            'last_name' => 'Gomez',
            'birth_of_date' => '2004-11-15',
            'school' => 'San Beda',
            'employment_type_id' => $k12Id,
            'role_id' => $memberRoleId,
            'strand_id' => $gasStrandId,
            'department_id' => $managementDeptId,
            'department_team_id' => $corpServicesTeamId,
            'position_id' => $pmPosId,
            'status' => 'Active',
            'contact_number' => '09334445566',
            'gender' => 'Female',
            'email' => 'samantha.gomez@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group1Id,
        ]);

        

        User::create([
            'employee_id' => 4006,
            'first_name' => 'Jessica',
            'last_name' => 'Mendoza',
            'birth_of_date' => '2001-01-12',
            'school' => 'PLM',
            'employment_type_id' => $collegeInternId,
            'role_id' => $memberRoleId,
            'department_id' => $managementDeptId,
            'department_team_id' => $corpServicesTeamId,
            'position_id' => $accountingId,
            'status' => 'Active',
            'contact_number' => '09175556600',
            'gender' => 'Female',
            'email' => 'jessica.mendoza@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group1Id,
        ]);

        User::create([
            'employee_id' => 4007,
            'first_name' => 'David',
            'last_name' => 'Lee',
            'birth_of_date' => '1999-04-08',
            'school' => 'Ateneo',
            'employment_type_id' => $gradApprenticeId,
            'role_id' => $memberRoleId,
            'department_id' => $digitalOpsDeptId,
            'department_team_id' => $webDevTeamId,
            'position_id' => $frontWebId,
            'status' => 'Active',
            'contact_number' => '09238889911',
            'gender' => 'Male',
            'email' => 'david.lee@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group1Id,
        ]);

        User::create([
            'employee_id' => 4008,
            'first_name' => 'Nina',
            'last_name' => 'De Vera',
            'birth_of_date' => '2003-08-30',
            'school' => 'Adamson University',
            'employment_type_id' => $collegeInternId,
            'role_id' => $memberRoleId,
            'department_id' => $managementDeptId,
            'department_team_id' => $cliServicesTeamId,
            'position_id' => $salesId,
            'status' => 'Exited',
            'contact_number' => '09339998877',
            'gender' => 'Female',
            'email' => 'nina.devera@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group2Id,
        ]);

        

        User::create([
            'employee_id' => 4010,
            'first_name' => 'Isabelle',
            'last_name' => 'Tan',
            'birth_of_date' => '2001-05-05',
            'school' => 'UST',
            'employment_type_id' => $collegeInternId,
            'role_id' => $memberRoleId,
            'department_id' => $digitalOpsDeptId,
            'department_team_id' => $creMultimediaTeamId,
            'position_id' => $grapDesignId,
            'status' => 'Active',
            'contact_number' => '09178881234',
            'gender' => 'Female',
            'email' => 'isabelle.tan@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group2Id,
        ]);

        User::create([
            'employee_id' => 4011,
            'first_name' => 'Jared',
            'last_name' => 'Chan',
            'birth_of_date' => '2000-10-20',
            'school' => 'Lyceum of the Philippines',
            'employment_type_id' => $gradApprenticeId,
            'role_id' => $memberRoleId,
            'department_id' => $managementDeptId,
            'department_team_id' => $cliServicesTeamId,
            'position_id' => $marketId,
            'status' => 'Active',
            'contact_number' => '09218889900',
            'gender' => 'Male',
            'email' => 'jared.chan@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group2Id,
        ]);

        User::create([
            'employee_id' => 4012,
            'first_name' => 'Trisha',
            'last_name' => 'Flores',
            'birth_of_date' => '2004-04-14',
            'school' => 'PUP Manila',
            'employment_type_id' => $k12Id,
            'role_id' => $memberRoleId,
            'strand_id' => $aniStrandId,
            'department_id' => $digitalOpsDeptId,
            'department_team_id' => $creMultimediaTeamId,
            'position_id' => $multimediaId,
            'status' => 'Active',
            'contact_number' => '09175559988',
            'gender' => 'Female',
            'email' => 'trisha.flores@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group2Id,
        ]);

        User::create([
            'employee_id' => 4013,
            'first_name' => 'Joyce',
            'last_name' => 'Pearl',
            'birth_of_date' => '2004-05-13',
            'school' => 'PUP Manila',
            'employment_type_id' => $k12Id,
            'role_id' => $memberRoleId,
            'strand_id' => $aniStrandId,
            'department_id' => $digitalOpsDeptId,
            'department_team_id' => $creMultimediaTeamId,
            'position_id' => $grapDesignId,
            'status' => 'Active',
            'contact_number' => '09175559988',
            'gender' => 'Female',
            'email' => 'joyce.pearl@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group2Id,
        ]);

        User::create([
            'employee_id' => 4014,
            'first_name' => 'Klara',
            'last_name' => 'Winter',
            'birth_of_date' => '2004-02-17',
            'school' => 'PUP Manila',
            'employment_type_id' => $k12Id,
            'role_id' => $memberRoleId,
            'strand_id' => $aniStrandId,
            'department_id' => $digitalOpsDeptId,
            'department_team_id' => $creMultimediaTeamId,
            'position_id' => $copywriterId,
            'status' => 'Active',
            'contact_number' => '09175559988',
            'gender' => 'Female',
            'email' => 'klara.winter@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group2Id,
        ]);

        User::create([
            'employee_id' => 4015,
            'first_name' => 'Hanna',
            'last_name' => 'Pangilinan',
            'birth_of_date' => '2009-12-15',
            'school' => 'PUP Manila',
            'employment_type_id' => $k12Id,
            'role_id' => $memberRoleId,
            'strand_id' => $progStrandId,
            'department_id' => $digitalOpsDeptId,
            'department_team_id' => $webDevTeamId,
            'position_id' => $frontWebId,
            'status' => 'Active',
            'contact_number' => '09175559988',
            'gender' => 'Female',
            'email' => 'hanna.pangilinan@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group2Id,
        ]);

        User::create([
            'employee_id' => 4016,
            'first_name' => 'Donny',
            'last_name' => 'Pangilinan',
            'birth_of_date' => '2015-10-05',
            'school' => 'PUP Manila',
            'employment_type_id' => $k12Id,
            'role_id' => $memberRoleId,
            'strand_id' => $progStrandId,
            'department_id' => $digitalOpsDeptId,
            'department_team_id' => $webDevTeamId,
            'position_id' => $backWebId,
            'status' => 'Active',
            'contact_number' => '09175559988',
            'gender' => 'Male',
            'email' => 'donny.pangilinan@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group2Id,
        ]);

        User::create([
            'employee_id' => 4017,
            'first_name' => 'Solana',
            'last_name' => 'Pangilinan',
            'birth_of_date' => '2008-05-01',
            'school' => 'PUP Manila',
            'employment_type_id' => $k12Id,
            'role_id' => $memberRoleId,
            'strand_id' => $gasStrandId,
            'department_id' => $managementDeptId,
            'department_team_id' => $cliServicesTeamId,
            'position_id' => $accountsId,
            'status' => 'Active',
            'contact_number' => '09175559988',
            'gender' => 'Female',
            'email' => 'solana.pangilinan@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group3Id,
        ]);

        User::create([
            'employee_id' => 4018,
            'first_name' => 'Gillian',
            'last_name' => 'Pangilinan',
            'birth_of_date' => '2004-04-14',
            'school' => 'PUP Manila',
            'employment_type_id' => $k12Id,
            'role_id' => $memberRoleId,
            'strand_id' => $gasStrandId,
            'department_id' => $managementDeptId,
            'department_team_id' => $cliServicesTeamId,
            'position_id' => $marketId,
            'status' => 'Active',
            'contact_number' => '09175559988',
            'gender' => 'Female',
            'email' => 'gillian.pangilinan@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group3Id,
        ]);

        User::create([
            'employee_id' => 4019,
            'first_name' => 'John',
            'last_name' => 'Villamor',
            'birth_of_date' => '2004-04-14',
            'school' => 'PUP Manila',
            'employment_type_id' => $k12Id,
            'role_id' => $memberRoleId,
            'strand_id' => $humssStrandId,
            'department_id' => $managementDeptId,
            'department_team_id' => $cliServicesTeamId,
            'position_id' => $marketId,
            'status' => 'Active',
            'contact_number' => '09175559988',
            'gender' => 'Male',
            'email' => 'john.villamor@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group3Id,
        ]);

        User::create([
            'employee_id' => 4020,
            'first_name' => 'Joaquin',
            'last_name' => 'Yawina',
            'birth_of_date' => '2004-04-14',
            'school' => 'PUP Manila',
            'employment_type_id' => $k12Id,
            'role_id' => $memberRoleId,
            'strand_id' => $humssStrandId,
            'department_id' => $managementDeptId,
            'department_team_id' => $cliServicesTeamId,
            'position_id' => $salesId,
            'status' => 'Active',
            'contact_number' => '09175559988',
            'gender' => 'Male',
            'email' => 'joaquin.yawina@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group3Id,
        ]);

        User::create([
            'employee_id' => 4021,
            'first_name' => 'Elijah',
            'last_name' => 'Buenavista',
            'birth_of_date' => '2004-04-14',
            'school' => 'PUP Manila',
            'employment_type_id' => $k12Id,
            'role_id' => $memberRoleId,
            'strand_id' => $humssStrandId,
            'department_id' => $managementDeptId,
            'department_team_id' => $cliServicesTeamId,
            'position_id' => $bsDevId,
            'status' => 'Active',
            'contact_number' => '09175559988',
            'gender' => 'Male',
            'email' => 'elijah.buenavista@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group3Id,
        ]);

        User::create([
            'employee_id' => 4022,
            'first_name' => 'Eren',
            'last_name' => 'Buenavista',
            'birth_of_date' => '2004-04-14',
            'school' => 'PUP Manila',
            'employment_type_id' => $k12Id,
            'role_id' => $memberRoleId,
            'strand_id' => $stemStrandId,
            'department_id' => $digitalOpsDeptId,
            'department_team_id' => $webDevTeamId,
            'position_id' => $frontWebId,
            'status' => 'Active',
            'contact_number' => '09175559988',
            'gender' => 'Male',
            'email' => 'eren.buenavista@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group3Id,
        ]);

         User::create([
            'employee_id' => 4023,
            'first_name' => 'Maddox',
            'last_name' => 'Buenavista',
            'birth_of_date' => '2004-04-14',
            'school' => 'PUP Manila',
            'employment_type_id' => $k12Id,
            'role_id' => $memberRoleId,
            'strand_id' => $stemStrandId,
            'department_id' => $digitalOpsDeptId,
            'department_team_id' => $webDevTeamId,
            'position_id' => $backWebId,
            'status' => 'Active',
            'contact_number' => '09175559988',
            'gender' => 'Male',
            'email' => 'maddox.buenavista@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group3Id,
        ]);

         User::create([
            'employee_id' => 4024,
            'first_name' => 'Ruhan',
            'last_name' => 'Buenavista',
            'birth_of_date' => '2004-04-14',
            'school' => 'PUP Manila',
            'employment_type_id' => $k12Id,
            'role_id' => $memberRoleId,
            'strand_id' => $stemStrandId,
            'department_id' => $managementDeptId,
            'department_team_id' => $corpServicesTeamId,
            'position_id' => $pmPosId,
            'status' => 'Active',
            'contact_number' => '09175559988',
            'gender' => 'Male',
            'email' => 'ruhan.buenavista@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group3Id,
        ]);

        

        User::create([
            'employee_id' => 4026,
            'first_name' => 'Rocco',
            'last_name' => 'Buenavista',
            'birth_of_date' => '2004-04-14',
            'school' => 'PUP Manila',
            'employment_type_id' => $collegeInternId,
            'role_id' => $memberRoleId,
            'department_id' => $managementDeptId,
            'department_team_id' => $corpServicesTeamId,
            'position_id' => $financeId,
            'status' => 'Active',
            'contact_number' => '09175559988',
            'gender' => 'Male',
            'email' => 'rocco.buenavista@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group4Id,
        ]);

        User::create([
            'employee_id' => 4027,
            'first_name' => 'Amber',
            'last_name' => 'Valencia',
            'birth_of_date' => '2004-04-14',
            'school' => 'PUP Manila',
            'employment_type_id' => $collegeInternId,
            'role_id' => $memberRoleId,
            'department_id' => $managementDeptId,
            'department_team_id' => $corpServicesTeamId,
            'position_id' => $pmPosId,
            'status' => 'Active',
            'contact_number' => '09175559988',
            'gender' => 'Female',
            'email' => 'amber.valencia@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group4Id,
        ]);

        User::create([
            'employee_id' => 4028,
            'first_name' => 'Mika',
            'last_name' => 'Alvarez',
            'birth_of_date' => '2004-04-14',
            'school' => 'PUP Manila',
            'employment_type_id' => $collegeInternId,
            'role_id' => $memberRoleId,
            'department_id' => $managementDeptId,
            'department_team_id' => $cliServicesTeamId,
            'position_id' => $accountsId,
            'status' => 'Active',
            'contact_number' => '09175559988',
            'gender' => 'Female',
            'email' => 'mika.alvarez@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group4Id,
        ]);

        User::create([
            'employee_id' => 4029,
            'first_name' => 'Sky',
            'last_name' => 'Francisco',
            'birth_of_date' => '2004-04-14',
            'school' => 'PUP Manila',
            'employment_type_id' => $collegeInternId,
            'role_id' => $memberRoleId,
            'department_id' => $managementDeptId,
            'department_team_id' => $cliServicesTeamId,
            'position_id' => $bsDevId,
            'status' => 'Active',
            'contact_number' => '09175559988',
            'gender' => 'Female',
            'email' => 'sky.francisco@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group4Id,
        ]);

        User::create([
            'employee_id' => 4030,
            'first_name' => 'Amara',
            'last_name' => 'Alonso',
            'birth_of_date' => '2004-04-14',
            'school' => 'PUP Manila',
            'employment_type_id' => $collegeInternId,
            'role_id' => $memberRoleId,
            'department_id' => $digitalOpsDeptId,
            'department_team_id' => $webDevTeamId,
            'position_id' => $aiPosId,
            'status' => 'Active',
            'contact_number' => '09175559988',
            'gender' => 'Female',
            'email' => 'amara.alonso@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group4Id,
        ]);

        User::create([
            'employee_id' => 4031,
            'first_name' => 'Cresia',
            'last_name' => 'Dela Cuesta',
            'birth_of_date' => '2004-04-14',
            'school' => 'PUP Manila',
            'employment_type_id' => $collegeInternId,
            'role_id' => $memberRoleId,
            'department_id' => $digitalOpsDeptId,
            'department_team_id' => $creMultimediaTeamId,
            'position_id' => $grapDesignId,
            'status' => 'Active',
            'contact_number' => '09175559988',
            'gender' => 'Female',
            'email' => 'cresia.delacuesta@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group4Id,
        ]);

        User::create([
            'employee_id' => 4032,
            'first_name' => 'Raya',
            'last_name' => 'Francisco',
            'birth_of_date' => '2004-04-14',
            'school' => 'PUP Manila',
            'employment_type_id' => $collegeInternId,
            'role_id' => $memberRoleId,
            'department_id' => $digitalOpsDeptId,
            'department_team_id' => $creMultimediaTeamId,
            'position_id' => $copywriterId,
            'status' => 'Active',
            'contact_number' => '09175559988',
            'gender' => 'Female',
            'email' => 'raya.francisco@example.com',
            'password' => Hash::make('password'),
            'group_id' => $group4Id,
        ]);

        

        

        

        

        

        

        

        

         

         

         

         
    }
}
