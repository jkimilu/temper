<?

require_once("config.php");




//get users belonging to each cohort
$sql_cohort_users="select WEEK(created_at) as cohort,count(*) as total_user_count from users GROUP BY WEEK(created_at) order by  WEEK(created_at) asc";

$query_cohort_users=mysql_query($sql_cohort_users);



$data = [];

echo "<div class='table-responsive'>";
echo "<table class='table table-striped table-hover'>";
echo "<tr><th>Cohort/Week</th><th>Stage</th><th>Total Count</th></tr>";
    

while($cohort_rows=mysql_fetch_assoc($query_cohort_users))
{
	
	
	
	$cohorts=[];
	$cohort=$cohort_rows["cohort"];
    $cohorts['name']= $cohort;

    //total users in cohort
    $user_count_in_cohort=$cohort_rows["total_user_count"];





    

	//get number of users in cohort per stage/step
    $corhort_by_week_sql="select onboarding_percentage as stage, count(*) as user_count from users where WEEK(created_at)='$cohort'  GROUP BY onboarding_percentage order by onboarding_percentage asc";

    //echo $corhort_by_week_sql;


    $corhort_by_week_query=mysql_query($corhort_by_week_sql);
    while($corhort_by_week_data=mysql_fetch_assoc($corhort_by_week_query))
    {
		$stage=$corhort_by_week_data["stage"];
        $user_count_in_stage=$corhort_by_week_data["user_count"];

        echo "<tr><td>$cohort</td><td>$stage %</td><td>$user_count_in_stage</td></tr>";
        //build cohort data, % of users in stage per cohort i.e cohort 29 has 47 users all in different stages 
        $stage=$corhort_by_week_data["stage"];
        $user_count_in_stage=$corhort_by_week_data["user_count"];

        $cohorts['data'][]=array((int)$stage,round(((int)$user_count_in_stage/$user_count_in_cohort)*100));

    }



    array_push($data,$cohorts);

}
echo "</table>";
echo "</div>";

