<?

require_once("config.php");



//get all cohorts 
$sql_cohort_users="select WEEK(created_at) as cohort,count(*) as total_user_count FROM users GROUP BY WEEK(created_at) ORDER BY  WEEK(created_at) asc";

$query_cohort_users=mysql_query($sql_cohort_users);


//initialize - to hold all cohorst
$data = [];

while($cohort_rows=mysql_fetch_assoc($query_cohort_users))
{
	
	
	//to hold each corhort
	$cohorts=[];
	$cohort=$cohort_rows["cohort"];
    $cohorts['name']= " Cohort $cohort";

    //total users in cohort
    $user_count_in_cohort=$cohort_rows["total_user_count"];


	//get number of users in cohort per stage/step
    $corhort_by_week_sql="select onboarding_percentage as stage, count(*) as user_count FROM users where WEEK(created_at)='$cohort'  GROUP BY onboarding_percentage ORDER BY onboarding_percentage asc";

    //echo $corhort_by_week_sql;

    $corhort_by_week_query=mysql_query($corhort_by_week_sql);
    while($corhort_by_week_data=mysql_fetch_assoc($corhort_by_week_query))
    {
		// % of users in stage per cohort i.e cohort 29 has 47 
        $stage=$corhort_by_week_data["stage"];
        $user_count_in_stage=$corhort_by_week_data["user_count"];

        $cohorts['data'][]=[(int)$stage,round(((int)$user_count_in_stage/$user_count_in_cohort)*100)];

    }


    //build cohort data for all cohorts
    array_push($data,$cohorts);

}

//out put json string -  required for highchart
echo json_encode($data,JSON_NUMERIC_CHECK);