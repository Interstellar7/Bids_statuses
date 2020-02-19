<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
  // header('Content-Type: text/html; charset=utf-8');
  $ID_CANCELLATION_STATUS = 8;
  $hostname="localhost";
  $username="-=username=-";
  $password="-=password=-";
  $dbname="-=bobrovgorset=-";

  $submit_num = $_GET['applnum'];
  $submit_email = $_GET['email'];
  
  $link = mysqli_connect($hostname, $username, $password, $dbname)
    or die("Error connection to database: " . mysqli_error($link));
  mysqli_set_charset($link, "utf8");
  $query_statuses = "SELECT * FROM application_statuses;";
  $query_apps = 'SELECT num_in_journal, applicant_name, applicant_address, object_name, object_address, number_of_phases, connected_power, cause_of_application, phone, email, id_current_status, application_statuses.status_name, comment_user, consideration_time, date_application, date_contract, date_payment, date_connection, comment_enterprise FROM appl_tech_connection LEFT JOIN application_statuses ON (appl_tech_connection.id_current_status = application_statuses.id_status) WHERE num_in_journal = '.$submit_num.' AND email = "'.$submit_email.'";';
  
  $result_statuses = mysqli_query($link, $query_statuses) or die("Error in query statuses " . mysql_error($link));
  $result_apps = mysqli_query($link, $query_apps) or die("Error in query apps " . mysql_error($link));
  if($result_apps)  {
   $num_rows = mysqli_num_rows($result_apps); // количество полученных строк
   if ($num_rows == 1) {
    $row = mysqli_fetch_row($result_apps);
    
    $num_in_journal = $row[0];
	$applicant_name = $row[1];
    $applicant_address = $row[2];
    $object_name = $row[3];
    $object_address = $row[4];
    $number_of_phases = $row[5];
    $connected_power = $row[6];
    $cause_of_application = $row[7];
    $phone = $row[8];
    $email = $row[9];
    $id_current_status = $row[10];
    $status_name = $row[11];
    $comment_user = $row[12];
    $consideration_time = $row[13];
    $date_application = $row[14];
    $date_contract = $row[15];
    $date_payment = $row[16];
    $date_connection = $row[17];
    $comment_enterprise = $row[18]; ?>	
	
    <h2 style="text-align: center;">Заявка на технологическое присоединение присоединение к электрическим сетям №<?php echo $num_in_journal; ?></h2>
    <table style="border-collapse: collapse; border-style: none;" border="0"><tbody>
      <tr><td style="width: 400; text-align: center;"><h3><b><i>Текущий статус заявки:</i></b></h3></td><td style="width: 400; text-align: left;"><h3><b><i>&nbsp;&nbsp;&nbsp;&nbsp;Комментарий горэлектросети:</i></b></h3></td></tr>
      <tr><td style="width: 400;">
        <table style="width: 100%; border-collapse: collapse; border-style: none;" border="0" cellpadding="8"><tbody>
          <?php
		  
		  $i = 1;
		  if ($id_current_status != $ID_CANCELLATION_STATUS) {
		    while($row_statuses=mysqli_fetch_array($result_statuses)) {
  			  if ($i < $id_current_status) {
                echo '<tr><td style="background-color: #faffa3;">&diams;&nbsp;'.$row_statuses['status_name'].'</td></tr>';				
			  } 
			  if ($i == $id_current_status) {
			    echo '<tr><td style="background-color: #37ff1c;"><b><h3>&diams;&nbsp;'.$row_statuses['status_name'].'</h3></b></td></tr>';
			  } 
			  if ($i > $id_current_status) {
                echo '<tr><td style="background-color: #e3e3e3;">&diams;&nbsp;'.$row_statuses['status_name'].'</td></tr>';
			  }
			  $i = $i + 1;
			}            			
          } else {
		    while($row_statuses=mysqli_fetch_array($result_statuses)) {
  			  if ($i < $id_current_status) {
                echo '<tr><td style="background-color: #e3e3e3;">&diams;&nbsp;'.$row_statuses['status_name'].'</td></tr>';				
			  } 
			  if ($i == $id_current_status) {
                echo '<tr><td style="background-color: #ff9999;">&diams;&nbsp;'.$row_statuses['status_name'].'</td></tr>';			  
			  }
			  $i = $i + 1;
			}
		  }  ?>
        </tbody></table>
      </td>
      <td style="width: 400; vertical-align: top; padding: 8"><p><?php echo $comment_enterprise; ?></p></td></tr>
    </tbody></table>      
	<h3>Данные по заявке:</h3>    
    <table style="border-collapse: collapse; width: 100%;" border="1" cellpadding="8"><tbody>
      <tr><td style="width: 400; text-align: left;">&nbsp;Номер в журнале регистраций заявок</td><td><?php echo $num_in_journal; ?></td></tr>
      <tr><td style="width: 400; text-align: left;">&nbsp;Фамилия Имя Отчество заявителя (собственника)</td><td><?php echo $applicant_name; ?></td></tr>
      <tr><td style="width: 400; text-align: left;">&nbsp;Адрес проживания заявителя</td><td><?php echo $applicant_address; ?></td></tr>
      <tr><td style="width: 400; text-align: left;">&nbsp;Наименование точки подключения</td><td><?php echo $object_name; ?></td></tr>
      <tr><td style="width: 400; text-align: left;">&nbsp;Адрес точки подключения</td><td><?php echo $object_address; ?></td></tr>
      <tr><td style="width: 400; text-align: left;">&nbsp;Количество фаз</td><td><?php echo $number_of_phases; ?></td></tr>
      <tr><td style="width: 400; text-align: left;">&nbsp;Необходимая максимальная мощность, кВт</td><td><?php echo $connected_power; ?></td></tr>
      <tr><td style="width: 400; text-align: left;">&nbsp;Причина обращения</td><td><?php echo $cause_of_application; ?></td></tr>
      <tr><td style="width: 400; text-align: left;">&nbsp;Контактный телефон</td><td><?php echo $phone; ?></td></tr>
      <tr><td style="width: 400; text-align: left;">&nbsp;E-mail пользователя</td><td><?php echo $email; ?></td></tr>
      <tr><td style="width: 400; text-align: left;">&nbsp;Комментарий пользователя</td><td><?php echo $comment_user; ?></td></tr>
      <tr><td style="width: 400; text-align: left;">&nbsp;Срок рассмотрения заявки</td><td><?php echo $consideration_time; ?></td></tr>
      <tr><td style="width: 400; text-align: left;">&nbsp;Дата подачи заявки</td><td><?php echo $date_application; ?></td></tr>
      <tr><td style="width: 400; text-align: left;">&nbsp;Дата заключения договора с выдачей техусловий</td><td><?php echo $date_payment; ?></td></tr>
      <tr><td style="width: 400; text-align: left;">&nbsp;Дата платежа</td><td><?php echo $date_connection; ?></td></tr>
      <tr><td style="width: 400; text-align: left;">&nbsp;Дата подключения</td><td><?php echo $date_connection; ?></td></tr>
    </tbody></table>
    &nbsp;
	  
	<?php  
   } else { echo 'Заявок с такими данными не найдено. проверьте № заявки или email.'; }
  }
  mysqli_close($link);
  ?>
  <p><a href="http://bobrovgorset.ru/личный-кабинет/">Вернуться в Личный кабинет</a></p>