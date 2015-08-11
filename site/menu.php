<?php
// +++++++++++ Левое меню +++++++++++++++++++++++++++++++++++++++++++++++++++++

// Выходим, если файл был запрошен напрямую, а не через include
if (!isset($MyPHPScript)) return;

?>
<script language = "JavaScript">

        // Функция проверки правильности заполнения формы
	function ValidateUserLoginForm()
	{ 
		if (document.UserLoginForm.Login.value == '') 
		{
			alert('Не указан e-mail.');           
			return false;
		} 

		if (!CheckEmail(document.UserLoginForm.Login.value)) 
		{
			alert('E-mail не проходит проверку формата.');           
			return false;
		} 
		

		if (document.UserLoginForm.Password.value == '') 
		{
			alert('Не указан пароль.');           
			return false;
		} 



		return true;
	}
        // Конец проверки правильности заполнения формы

	
	function UserLogout()
	{ 
		document.UserLoginForm.action.value = "UserLogout";
		document.UserLoginForm.submit();
	}

	/*function ViewUserInfo(userid)
	{ 
		document.UserLoginForm.action.value = "UserInfo";
		document.UserLoginForm.UserId.value = userid;
		document.UserLoginForm.submit();
	}*/

        // Одинаковые действия при  регистрации поьзователя и обновленииданных.
	// Не уверен, что правильно так
	function NewUser()
	{ 
		document.UserLoginForm.action.value = "ViewNewUserForm";
		document.UserLoginForm.submit();
	}


	// Функция отправки письма
	function RestorePassword()
	{ 
		document.UserLoginForm.action.value = "RestorePasswordRequest";
		document.UserLoginForm.submit();
	}


	// Функция проверки e-mail
	function CheckEmail(email) 
	{
		var template = /^[A-Za-z0-9_\.\-]+@[A-Za-z0-9\-\_\.]+\.[A-Za-z0-9]{2,6}$/;
//		var template = /^[A-Za-z0-9_\.]+@[A-Za-z0-9]+\.[A-Za-z0-9]{2,6}$/;
//		var template = /^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z])+$/;
//		email = drop_spaces(email); //функцию drop_spaces() см. выше
		if (template.test(email)) 
		{
		        return true;
		}
		return false; 
	}
	
	function trimLeft(str) {
	  return str.replace(/^\s+/, '');
	}

	function trimRight(str) {
	  return str.replace(/\s+$/, '');
	}

	function trimBoth(str) {
	  return trimRight(trimLeft(str));
	}

	function trimSpaces(str) {
	  return str.replace(/\s{2,}/g, ' ');
	}

        function _onClick(ctrl, val)
        {
	        if (trimBoth(ctrl.value) == val)
		        ctrl.value = '';
        }

        function _onBlur(ctrl, val)
        {
	        if (trimBoth(ctrl.value) == '')
		        ctrl.value = val;
        }
	

</script>

<?php
        // какое выводить меню
	if ($UserId <= 0)
	{
		print('<form  name = "UserLoginForm"  action = "'.$MyPHPScript.'" method = "post" onSubmit = "return ValidateUserLoginForm();">'."\r\n");
                print('<input type = "hidden" name = "action" value = "UserLogin">'."\r\n"); 
		print('<input type = "hidden" name = "view" value = "'.$view.'">'."\r\n");
		print('<table  class = "menu" border = "0" cellpadding = "0" cellspacing = "0">'."\r\n");
		print('<tr><td class = "input"><input type="text" name="Login"
                       style="width: 185px;" value="E-mail" tabindex = "101" ' . CMmbUI::placeholder('E-mail')
			."></td></tr>\r\n");
		print('<tr><td class = "input"><input type="password" name="Password"  style = "width:101px;" size="10" value="" tabindex = "102">
                            <input type="submit" name="RegisterButton" value="Вход" tabindex = "103"  style = "margin-left: 25px; width: 55px;"></td></tr>'."\r\n"); 
		print('<tr><td><a href = "javascript:RestorePassword();"  title = "Будет выслан запрос о сменен пароля на указанный выше e-mail">Забыли пароль?</a></td></tr>'."\r\n"); 
		print('<tr><td><a href = "javascript:NewUser();"  title = "Переход к форме регистрации нового пользователя">Новый пользователь</a></td></tr>'."\r\n"); 
		print('</table>'."\r\n");
		print('</form>'."\r\n");
	} else {
		$UserName = CMmbUi::toHtml(CSql::userName($UserId));
                print('<form  name="UserLoginForm"  action="'.$MyPHPScript.'" method="post">'."\r\n");
                print('<input type="hidden" name="action" value="">'."\r\n");
                print('<input type="hidden" name="UserId" value="">'."\r\n");
		print('<input type="hidden" name="view" value="'.$view.'">'."\r\n");
		print('<table  class="menu" border="0" cellpadding="0" cellspacing="0">'."\r\n");
		print('<tr><td><a href="?UserId='.$UserId.'" title="Переход к Вашей карточке пользователя">'.$UserName.'</a></tr>'."\r\n");
		print('<tr><td><a href="javascript:UserLogout();" style="font-size: 80%;">Выход</a></td></tr>'."\r\n");
		print('</table>'."\r\n");
		print('</form>'."\n");
	}
		print('</br>'."\n");


?>


<script language="JavaScript">


	        // Функция проверки правильности заполнения формы
	function ValidateFindTeamForm()
	{ 
		if (document.FindTeamForm.TeamNum.value == '') 
		{
			alert('Не указан номер команды.');           
			return false;
		} 

		if (document.FindTeamForm.RaidId.value <= 0) 
		{
			alert('Не выбран ММБ.');           
			return false;
		} 

		return true;
	}

	function NewTeam()
	{ 
		document.FindTeamForm.action.value = "RegisterNewTeam";
		document.FindTeamForm.submit();
	}

/*
	function RaidTeams()
	{ 
		document.FindTeamForm.action.value = "ViewRaidTeams";
		document.FindTeamForm.submit();
	}*/

/*
    Перенёс функции в отдельную страницу    
	function RecalcRaidResults()
	{ 
              document.AdminServiceForm.action.value = "RecalcRaidResults";
              document.AdminServiceForm.RaidId.value = document.FindTeamForm.RaidId.value; 
	      document.AdminServiceForm.submit();
              return true;
	}

	function FindRaidErrors()
	{
              document.AdminServiceForm.action.value = "FindRaidErrors";
              document.AdminServiceForm.RaidId.value = document.FindTeamForm.RaidId.value;
	      document.AdminServiceForm.submit();
              return true;
	}

	function ClearTables()
	{ 
		document.AdminServiceForm.action.value = "ClearTables";
		document.AdminServiceForm.submit();
	}

*/
        function ShowEmail()
	{
         var begstr = "<? echo substr(trim($_SERVER['SERVER_NAME']), 0, 4); ?>";
         var endstr = "<? echo substr(trim($_SERVER['SERVER_NAME']), -3); ?>";
          
	  begstr = begstr.replace("\.","site\@");
	  endstr = endstr.replace("\.ru","\.com");
	  begstr = begstr + "googlegroups" + endstr;
	  alert(begstr);
	}


	function NewRaid()
	{ 
		document.FindTeamForm.action.value = "RegisterNewRaid";
		document.FindTeamForm.submit();
	}


	function ViewRaidInfo()
	{ 
		document.FindTeamForm.action.value = "RaidInfo";
		document.FindTeamForm.submit();
	}


	function ViewAdminModeratorsPage()
	{ 
		document.FindTeamForm.action.value = "ViewAdminModeratorsPage";
		document.FindTeamForm.submit();
	}

	function ViewRaidFiles()
	{ 
		document.FindTeamForm.action.value = "ViewRaidFilesPage";
		document.FindTeamForm.submit();
	}

	function ViewLevelPoints()
	{ 
		document.FindTeamForm.action.value = "ViewLevelPointsPage";
		document.FindTeamForm.submit();
	}

	function ViewScanPoints()
	{ 
		document.FindTeamForm.action.value = "ViewScanPointsPage";
		document.FindTeamForm.submit();
	}



	function ViewLevelPointDiscounts()
	{ 
		document.FindTeamForm.action.value = "ViewLevelPointDiscountsPage";
		document.FindTeamForm.submit();
	}

	function ViewAdminDataPage()
	{ 
		document.FindTeamForm.action.value = "ViewAdminDataPage";
		document.FindTeamForm.submit();
	}

	
	function ViewAdminUnionPage()
	{ 
		document.FindTeamForm.action.value = "ViewAdminUnionPage";
		document.FindTeamForm.submit();
	}

	function ChangeRaid()
	{ 
		document.FindTeamForm.action.value = "";
		document.FindTeamForm.submit();
	}


	function ViewUserUnionPage()
	{ 
		document.FindTeamForm.action.value = "ViewUserUnionPage";
		document.FindTeamForm.submit();
	}


	function ViewRaidsUsersLinksPage()
	{ 
		document.FindTeamForm.action.value = "ViewUsersLinksPage";
		document.FindTeamForm.submit();
	}

	function ViewAllRaidsBadgesPage()
	{ 
		document.FindTeamForm.action.value = "ViewAllBadgesPage";
		document.FindTeamForm.submit();
	}



</script>

<?php
	
	// выводим окно для поиска команды 
	print('<form name="FindTeamForm"  action="'.$MyPHPScript.'" method="post" onSubmit="return ValidateFindTeamForm();">'."\r\n");

	print('<input type="hidden" name="action" value="FindTeam">'."\r\n");
	print('<input type="hidden" name="view" value="'.$view.'">'."\r\n");
        // Эта переменная нужна только тогда, когда из спиcка марш-бросков выбирают дистанцию
	print('<input type="hidden" name="DistanceId" value="0">'."\r\n");
	print('<table class="menu" border="0" cellpadding="0" cellspacing="0">'."\r\n");
	print('<tr><td class="input">ММБ'."\r\n");
	print('<select name="RaidId"  style="width: 141px; margin-left: 5px;" tabindex="201"  title="Список марш-бросков" onClick="/* ChangeLogo(this.value); */" onchange="ChangeLogo(this.value); ChangeRaid();">'."\r\n");

		$notAdmin = $Administrator ? "true" : "raid_registrationenddate is not null";
                $sql = "select raid_id, raid_name from Raids
                            where $notAdmin
                            order by raid_id desc ";
		
                $Result = MySqlQuery($sql);

		while ($Row = mysql_fetch_assoc($Result))
		{
		  print('<option value="'.$Row['raid_id'].'"  '.(($Row['raid_id'] == $RaidId) ? 'selected' : '').' onclick="/* javascript: ChangeRaid(); */">'.$Row['raid_name']."</option>\r\n");
		}

                mysql_free_result($Result);
	print("</select>\r\n");
	print("</td></tr>\r\n");
 
        // 19/06/2015 Пользователь должен быть авторизован и иметь права
	if ($UserId && CanCreateTeam($Administrator, $Moderator, $OldMmb, $RaidStage, $TeamOutOfRange))
	{
		print('<tr><td><a href="javascript:NewTeam();" title="Переход к форме регистрации новой команды на выбранный выше ММБ">Новая команда</a></td></tr>'."\r\n");
	}
	print('<tr><td><a href="?RaidId='.$RaidId.'" title="Список команд для выбранного выше ММБ">Команды</a></td></tr>'."\r\n");
        // Впечатываем ссылку на администрирование

        // Ввод/ПРавка марш-броска
	if ($Administrator)
        { 
	    print('<tr><td><a href="javascript:NewRaid();" title="Создание марш-броска">Новый марш-бросок</a></td></tr>'."\r\n");
	    print('<tr><td><a href="javascript:ViewRaidInfo();" title="Параметры марш-броска">Марш-бросок</a></td></tr>'."\r\n");
	    print('<tr><td><a href="javascript:ViewAdminModeratorsPage();" title="Страница администрирования модераторов">Модераторы</a></td></tr>'."\r\n");
        }


        // Точки сканирования 
	if ($Administrator || $Moderator )
        {
	  print('<tr><td><a href = "javascript:ViewScanPoints();" title = "Список точек сканирования для выбранного выше ММБ">Скан-точки</a></td></tr>'."\r\n"); 
        }
	 


          // Не показываем, т.к. некрасиво смотрится и не очень интересно
        // Точки показываем только после финиша
	if ($Administrator || $Moderator)
        {
	  print('<tr><td><a href = "javascript:ViewLevelPoints();" title = "Список точек (КП) для выбранного выше ММБ">Точки (КП)</a></td></tr>'."\r\n"); 
        }
	 
        // Амнистия для интервала КП
	if ($Administrator || $Moderator)
	{
	    print('<tr><td><a href = "javascript:ViewLevelPointDiscounts();" title = "Страница интервалов КП с амнистией">Амнистия</a></td></tr>'."\r\n"); 
        }


        // Файлы
        print('<tr><td><a href="?files&RaidId='.$RaidId.'" title="Список файлов для выбранного выше ММБ">Материалы</a></td></tr>'."\r\n");
    



        // Импорт-Экспорт, пересчет
	if ($Administrator || $Moderator)
	{
	    print('<tr><td><a href = "javascript:ViewAdminDataPage();" title = "Страница администрирования экспорта-импорта">Обмен данными</a></td></tr>'."\r\n"); 
        }
        
	// Объхединение команд
	if ($Administrator || $Moderator)
	{
	    print('<tr><td><a href = "javascript:ViewAdminUnionPage();" title = "Страница администрирования объединения команд">Объединение команд</a></td></tr>'."\r\n"); 
        }


	// Объхединение пользователей могут смотреть все, зарегистрированные пользователи, но отображается по-разному:
	// Администратоору - всё, остальным только их запросы или запросы с их участием 
	if ($UserId)
	{
	    print('<tr><td><a href = "javascript:ViewUserUnionPage();" title = "Страница администрирования объединения пользователей">Связь пользователей</a></td></tr>'."\r\n"); 
        }


        // Впечатления
        print('<tr><td><a href="?links&RaidId='.$RaidId.'" title="Список впечатлений для выбранного выше ММБ">Впечатления</a></td></tr>'."\r\n");

        // Все значки
        print('<tr><td><a href = "?badges" title = "Значки для всех ММБ">Все значки</a></td></tr>'."\r\n");


        print('<tr><td><a href="?rating" title = "Страница рейтинга пользователей">Рейтинг</a></td></tr>'."\r\n");
        
	//print('<tr><td class = "input">Поиск:</td></tr>'."\r\n"); 
	print('<tr><td style = "padding-top: 15px;"><input  type="text" name="TeamNum" style = "width: 125px;" value="Номер команды" tabindex = "206"  title = "Будет выведена карточка команды с указанным номером для выбранного выше ММБ"'.
			CMmbUI::placeholder('Номер команды') . '>
	       <input type="submit"  name="FindButton" value="Найти"   style = "width: 55px; margin-left: 5px;" tabindex = "207"></td></tr>'."\r\n"); 
	print('</table>'."\r\n");
	print('</form>'."\r\n");
	// Поиск участника
	print('<form  name = "FindUserForm"  action = "'.$MyPHPScript.'" method = "post" onSubmit = "return ValidateFindUserForm();">'."\r\n");
	print('<input type = "hidden" name = "action" value = "FindUser">'."\r\n"); 
	print('<input type = "hidden" name = "view" value = "'.$view.'">'."\r\n");
	print('<input type = "hidden" name = "RaidId" value = "'.$RaidId.'">'."\r\n");
	print('<input type = "hidden" name = "DistanceId" value = "0">'."\r\n");
	print('<table  class = "menu" border = "0" cellpadding = "0" cellspacing = "0">'."\r\n");
	//print('<tr><td class = "input">Поиск пользователя</td></tr>'."\r\n"); 
	print('<tr><td class = "input"><input  type="text" name="FindString" style = "width:125px;" value="Часть ФИО" tabindex = "301" 
	       title = "Будет выведен список пользователей, чьи ФИО содержат указанный текст. Для вывода всех наберите: все-все (можно и все-все-все)."'
			.CMmbUI::placeholder('Часть ФИО') . '>
	       <input type="submit"  name="FindButton" value="Найти" style = "width: 55px; margin-left: 5px;"  tabindex = "302"></td></tr>'."\r\n"); 
	print('</table>'."\r\n");
	print('</form>'."\r\n");
	print('</br>'."\r\n");

/*

Перенёс на отдельную страницу
       // Форма сервисов администратора и модератора
        if ($Administrator || $Moderator)
	{
	  print('<form  name = "AdminServiceForm"  action = "'.$MyPHPScript.'" method = "post" onsubmit = "return true;">'."\r\n");
	  print('<input type = "hidden" name = "action" value = "">'."\r\n"); 
	  print('<input type = "hidden" name = "view" value = "'.$view.'">'."\r\n");
	  print('<input type = "hidden" name = "RaidId" value = "0">'."\r\n");


          //  показываем кнопку "Пересчёт результатов" 
	  if ($Administrator)
	  {
		print('<input type="button" style = "width:185px;" name="RecalcRaidResultsButton" value="Пересчитать результаты"
                          onclick = "javascript: RecalcRaidResults();"
                          tabindex = "401">'."\r\n"); 
		print('</br>'."\r\n");
	  }

          //  показываем кнопку "Поиск ошибок"
          print('<input type="button" style = "width:185px;" name="FindRaidErrorsButton" value="Найти ошибки"
                          onclick = "javascript: FindRaidErrors();"
                          tabindex = "402">'."\r\n");
	  print('</br>'."\r\n");

   	  print('</form>'."\r\n");
	  print('</br>'."\r\n");

	} 
*/		
	// Внешние сылки
	print('<table  class = "menu" border = "0" cellpadding = "0" cellspacing = "0">'."\r\n");
	print('<tr><td><a href="http://www.livejournal.com/community/_mmb_" target = "_blank">ЖЖ</a></td></tr>'."\r\n"); 
	print('<tr><td><a href="http://slazav.mccme.ru/maps/" target = "_blank">Карты</a></td></tr>'."\r\n"); 
	print('<tr><td><a href="'.$MyLocation.'vp_old.html" target = "_blank">Архив впечатлений</a></td></tr>'."\r\n"); 
	//print('<tr><td><a href="http://mmb.progressor.ru/icons.html" target = "_blank">Значки</a></td></tr>'."\r\n"); 
	print('<tr><td> <a href="http://slazav.mccme.ru/mmb/" target = "_blank">Архив сайта</a></td></tr>'."\r\n"); 
	print('</table>'."\r\n");

	print('</br>'."\r\n");

        // Почта
	print('<table  class = "menu" border = "0" cellpadding = "0" cellspacing = "0">'."\r\n");
	print('<tr><td><a style = "font-family: Times New Roman, Serif; font-size: 100%;" href="javascript: ShowEmail();" title = "Адрес латинскими буквами или кликните мышкой">ммбсайт@googlegroups.com</a></td></tr>'."\r\n");
        print('<tr><td><a href="https://github.com/realtim/mmb/wiki/%D0%A1%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D1%8F-%D0%BE-%D1%81%D0%B5%D1%80%D0%B2%D0%B8%D1%81%D0%B5-%D0%9C%D0%9C%D0%91"  target = "_blank">О сервисе</a>, 
                       <a href="https://github.com/realtim/mmb/wiki/%D0%90%D0%B2%D1%82%D0%BE%D1%80%D1%8B" target = "_blank">Авторы</a>
               </td></tr>'."\r\n"); 
	print('<tr><td><a href="https://github.com/realtim/mmb/wiki/%D0%92%D0%BE%D0%BF%D1%80%D0%BE%D1%81%D1%8B-%D0%B8-%D0%BE%D1%82%D0%B2%D0%B5%D1%82%D1%8B"  target = "_blank">Вопросы и ответы</a></td></tr>'."\r\n"); 
	print('</table>'."\r\n");

	
?>
