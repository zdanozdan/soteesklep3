<?php
$lang->address_book_add="Добавь адрес";
$lang->nologin="отсутствие id  клиента";
$lang->users_discount="Основная скидка";
$lang->users_group="Группа";
$lang->users_remind_title="Напомнить пароль конта клиента";
$lang->users_forgot_password="Напомнить пароль?";
$lang->users_click_here="Нажми здесь";
$lang->users_remind_info1="Если не помнишь своего пароля,то впиши нижей адрес e-mail. на твое конто e-mail вышлем новый пароль.";
$lang->users_remind_info2="<p>к сожалению не можем окрыть твоего старего пароля, для безопасности, не оставляем                           некодированный пароль для этого с системы получишь новый пароль, kоторое потом можешь изменить                          войди в магазин.</p>";
$lang->users_email="Впиши e-mail";
$lang->users_send="Вышли новый пароль";
$lang->users_email_not_exists="Нету такего адреса e-mailв базе, или адрес имеет ошибку";
$lang->users_remind_sent="На твое конто e-mail выслан новый пароль. проверь почту.";
$lang->users_remind_subject="Напоминаем пароль с магазина-интернет";
$lang->users_remind_body="Ув.г-н.

System nadal Твое конто имеет новый пароль.
nчтобы войти в магазин {PROTOCOL}://{WWW} следует вписать следующие данные:

Логин: {LOGIN}
пароль: {PASSWORD}

если хочешь войти нажми здесь: {PROTOCOL}://{WWW}/go/_users/
По входу до магазина можно изменить пароль.

--
Автоматическая генерация ведомости
";
$lang->users_password_info="Если хочешь изменить пароль своего конта, оформи нижеследующий формуляр";
$lang->users_old_password="Старый пароль";
$lang->users_new_password="пароль";
$lang->users_password_errors=array(
                'old_password'=>"Новый пароль",
                'password'=>"Новый пароль, Впиши мин. 6 знаков",
                'password2'=>"ошибка в другом пароле",
                );
$lang->users_password_changed="Твой пароль изменился";
$lang->users_register_billing_form_errors=array(
                'name'=>"отсутствие",
                'surname'=>"отсутствие фамилии",
                'street'=>"отсутствие улицы",
                'street_n1'=>"отсутствие номера дома",
                'postcode'=>"отсутствие индекса",
                'city'=>"отсутствие название города",
                'phone'=>"отсутствие номера телефона",
                'email'=>"ошибочный адрес email",
                );
$lang->reminder_form_errors=array(
                'month'=>"неправильный формат даты",
                'day'=>"неправильный формат даты",
                'occasion'=>"присвой причину",
                'event'=>"отсутствие данных для этой строки",
                'advise'=>"cyklicznosc wydarzenia",
                'handling1'=>"Выбери способ сообщения",
                'handling2'=>"Выбери способ сообщения",
                'handling3'=>"Выбери способ сообщения",
                );
$lang->occasion=array(
                '0'=>"Imieniny",
                '1'=>"день рождения",
                '2'=>"Годовщина",
                '3'=>"Инная",
                '4'=>"-- причина --",
                '5'=>"поздравляем",
                '6'=>"День рождение ребёнка",
                '7'=>"любовь",
                '8'=>"благодарность",
                '9'=>"приветствие",
                '10'=>" Праздник --",
                '11'=>"B�ogos�awie�stwo",
                '12'=>"день мамы",
                '13'=>"день учителя",
                '14'=>"день отца",
                '15'=>"Halloween",
                '16'=>"Walentynki",
                '17'=>"пасха",
                '18'=>"рождество",
                );
$lang->reminder_subject = "Напоминание- записная книжка сайта";
$lang->reminder_fields=array(
                'occasion'=>'Оказия',
                'person'=>'Лицо / Случай',
                'date'=>'Дата',
                );
$lang->advise=array(
                'annually'=>"каждый год",
                'once'=>"одноразовый",
                );
$lang->add_reminder="Добавь в терминаж";
$lang->users_address_book="Адресная книга";
$lang->users_reminder="Терминология";
$lang->order_basket=array(
                'name'=>"nназвание продукта",
                'options'=>"опция",
                'user_id'=>"id",
                'price_netto'=>"цена нетто",
                'vat'=>"НДС",
                'num'=>"ilo��",
                'price_brutto'=>"цена брутто",
                'sum'=>"сумма",
                );
$lang->order_names=array(
                'order_id'=>"Номер трансакции",
                'amount'=>"Сумма оплаты",
                'delivery_cost'=>"Стоимость доставы",
                'id_currency'=>"Валюта",
                'id_pay_method'=>"Платёж",
                'date_add'=>"дата трансакции",
                'time_add'=>"час",
                'xml_description'=>"заказ",
                'id_user'=>"id пользователя",
                'xml_user'=>"данные заказчика",
                'name'=>"заказчик",
                'id_delivery'=>"поставщик",
                'id_status'=>"Status",
                'confirm'=>"заплачено",
                'confirm_user'=>"подтверждение mailem",
                'description'=>"дополнительные информации",
                'status'=>"Статус",
                'checksum'=>"сумма контроли трансакции",
                'send_date'=>"дата выслания пресылки",
                'send_number'=>"Номер посылки",
                'send_confirm'=>"Посылка отправлена",
                );
$lang->users_bar="Добро пожаловать в панели пользователя !";
$lang->plugins_transuser_ask4trans="Вопрос о состоянии трансакции:";
$lang->plugins_transuser_ask4="Вопрос о трансакции";
$lang->trans_bar_title="Моя трансакция";
$lang->trans_products="Номер трансакции:";
$lang->users_add_error="Ошибка при попытке добавления до базы";
$lang->users_logout_action="Спасибо за то, что Вы нас навестили, приглашаем вновь!";
$lang->users_order_status_undefined="Неопределённый";
$lang->users_paste="Вставить";
$lang->users_edit="Редактировать";
$lang->users_delete="Удалить";
$lang->users_status="Статус";
$lang->users_entry_updated="Запись актуализировано в Адресной книге";
$lang->users_entry_added="Запись добавлено в Адресную книгу";
$lang->users_entry_deleted="Запись удалено из Адресной книги";
$lang->users_entry_added2="Запись добавлено в форму как <b>адрес отправления</b>";
$lang->points_unit="п.";
?>