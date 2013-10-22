<html>
<head>
    <?php
    $url = Yii::app()->request->baseUrl;

    $cs = Yii::app()->getClientScript();
    $cs->registerCSSFile($url . '/skins/larry/css/style.css');
    $cs->registerCSSFile($url . '/skins/larry/css/main.css');
    $cs->registerCssFile($cs->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');

    $cs->registerCoreScript( 'jquery.ui' );
    $cs->registerCoreScript( 'jquery' );
    $cs->registerScriptFile($url . '/program/js/ui.js');
    $cs->registerScriptFile($url . '/program/js/common.js');
    $cs->registerScriptFile($url . '/program/js/app.js');
    $cs->registerScriptFile($url . '/program/js/treelist.js');
    $cs->registerScriptFile($url . '/program/js/list.js');

    ?>

</head>
<body>

<script type="text/javascript">

    var rcmail = new rcube_webmail();
    rcmail.set_env({"task":"mail","x_frame_options":"sameorigin","standard_windows":false,"cookie_domain":"","cookie_path":"\/","cookie_secure":false,"skin":"larry","refresh_interval":60,"session_lifetime":600,"action":"","comm_path":".\/?_task=mail","date_format":"yy-mm-dd","search_mods":{"*":{"subject":1,"from":1},"INBOX.Sent":{"subject":1,"to":1},"INBOX.Drafts":{"subject":1,"to":1}},"mailbox":"INBOX","pagesize":50,"delimiter":".","threading":false,"threads":true,"preview_pane_mark_read":0,"read_when_deleted":true,"display_next":true,"trash_mailbox":"INBOX.Trash","drafts_mailbox":"INBOX.Drafts","junk_mailbox":"INBOX.Junk","mailboxes":{"INBOX":{"id":"INBOX","name":"\u0412\u0445\u043e\u0434\u044f\u0449\u0438\u0435","virtual":false},"INBOX.Drafts":{"id":"INBOX.Drafts","name":"\u0427\u0435\u0440\u043d\u043e\u0432\u0438\u043a\u0438","virtual":false},"INBOX.Sent":{"id":"INBOX.Sent","name":"\u041e\u0442\u043f\u0440\u0430\u0432\u043b\u0435\u043d\u043d\u044b\u0435","virtual":false},"INBOX.Trash":{"id":"INBOX.Trash","name":"\u041a\u043e\u0440\u0437\u0438\u043d\u0430","virtual":false}},"unreadwrap":"%s","collapsed_folders":"","col_movable":true,"autoexpand_threads":0,"sort_col":"","sort_order":"DESC","messages":[],"coltypes":["threads","subject","status","fromto","date","size","flag","attachment"],"disabled_sort_col":false,"disabled_sort_order":false,"blankpage":"skins\/larry\/watermark.html","contentframe":"messagecontframe","max_filesize":2097152,"filesizeerror":"\u0417\u0430\u0433\u0440\u0443\u0436\u0435\u043d\u043d\u044b\u0439 \u0444\u0430\u0439\u043b \u0431\u043e\u043b\u044c\u0448\u0435 \u043c\u0430\u043a\u0441\u0438\u043c\u0430\u043b\u044c\u043d\u043e\u0433\u043e \u0440\u0430\u0437\u043c\u0435\u0440\u0430 \u0432 2,0 \u041c\u0411.","request_token":"53afd4ca717d836a5bc9683a4bdf0575"});
    rcmail.gui_container("topline-left","topline-left");
    rcmail.gui_container("topline-center","topline-center");
    rcmail.gui_container("topline-right","topline-right");
    rcmail.gui_container("taskbar","taskbar");
    rcmail.gui_container("toolbar","mailtoolbar");
    rcmail.gui_container("forwardmenu","forwardmenu");
    rcmail.gui_container("replyallmenu","replyallmenu");
    rcmail.gui_container("messagemenu","messagemenu");
    rcmail.gui_container("markmenu","markmessagemenu");
    rcmail.gui_container("listcontrols","listcontrols");
    rcmail.gui_container("mailboxoptions","mailboxoptionsmenu");
    rcmail.add_label({"loading":"\u0417\u0430\u0433\u0440\u0443\u0437\u043a\u0430...","servererror":"\u041e\u0448\u0438\u0431\u043a\u0430 \u0441\u0435\u0440\u0432\u0435\u0440\u0430!","requesttimedout":"\u041f\u0440\u0435\u0432\u044b\u0448\u0435\u043d\u043e \u0432\u0440\u0435\u043c\u044f \u043e\u0436\u0438\u0434\u0430\u043d\u0438\u044f \u0437\u0430\u043f\u0440\u043e\u0441\u0430","refreshing":"\u041e\u0431\u043d\u043e\u0432\u043b\u0435\u043d\u0438\u0435...","checkingmail":"\u041f\u0440\u043e\u0432\u0435\u0440\u043a\u0430 \u043d\u043e\u0432\u044b\u0445 \u0441\u043e\u043e\u0431\u0449\u0435\u043d\u0438\u0439...","deletemessage":"\u0412 \u043a\u043e\u0440\u0437\u0438\u043d\u0443","movemessagetotrash":"\u041f\u0435\u0440\u0435\u043c\u0435\u0441\u0442\u0438\u0442\u044c \u0441\u043e\u043e\u0431\u0449\u0435\u043d\u0438\u0435 \u0432 \u043a\u043e\u0440\u0437\u0438\u043d\u0443","movingmessage":"\u041f\u0435\u0440\u0435\u043c\u0435\u0449\u0435\u043d\u0438\u0435 \u0441\u043e\u043e\u0431\u0449\u0435\u043d\u0438\u044f(\u0439)\u2026","copyingmessage":"\u041a\u043e\u043f\u0438\u0440\u043e\u0432\u0430\u043d\u0438\u0435 \u0441\u043e\u043e\u0431\u0449\u0435\u043d\u0438\u044f(\u0439)...","deletingmessage":"\u0423\u0434\u0430\u043b\u0435\u043d\u0438\u0435 \u0441\u043e\u043e\u0431\u0449\u0435\u043d\u0438\u044f(\u0439)...","markingmessage":"\u0412\u044b\u0434\u0435\u043b\u0435\u043d\u0438\u0435 \u0441\u043e\u043e\u0431\u0449\u0435\u043d\u0438\u044f(\u0439)...","copy":"\u041a\u043e\u043f\u0438\u0440\u043e\u0432\u0430\u0442\u044c","move":"\u041f\u0435\u0440\u0435\u043c\u0435\u0441\u0442\u0438\u0442\u044c","quota":"\u041a\u0432\u043e\u0442\u0430","replyall":"\u041e\u0442\u0432\u0435\u0442\u0438\u0442\u044c \u0432\u0441\u0435\u043c","replylist":"\u041e\u0442\u0432\u0435\u0442\u0438\u0442\u044c \u0432 \u0441\u043f\u0438\u0441\u043e\u043a \u0440\u0430\u0441\u0441\u044b\u043b\u043a\u0438","importwait":"\u0418\u043c\u043f\u043e\u0440\u0442\u0438\u0440\u043e\u0432\u0430\u043d\u0438\u0435, \u043f\u043e\u0436\u0430\u043b\u0443\u0439\u0441\u0442\u0430, \u043f\u043e\u0434\u043e\u0436\u0434\u0438\u0442\u0435...","purgefolderconfirm":"\u0412\u044b \u0434\u0435\u0439\u0441\u0442\u0432\u0438\u0442\u0435\u043b\u044c\u043d\u043e \u0445\u043e\u0442\u0438\u0442\u0435 \u0443\u0434\u0430\u043b\u0438\u0442\u044c \u0432\u0441\u0435 \u0441\u043e\u043e\u0431\u0449\u0435\u043d\u0438\u044f \u0432 \u044d\u0442\u043e\u0439 \u043f\u0430\u043f\u043a\u0435?","deletemessagesconfirm":"\u0412\u044b \u0434\u0435\u0439\u0441\u0442\u0432\u0438\u0442\u0435\u043b\u044c\u043d\u043e \u0445\u043e\u0442\u0438\u0442\u0435 \u0443\u0434\u0430\u043b\u0438\u0442\u044c \u0432\u044b\u0431\u0440\u0430\u043d\u043d\u044b\u0435 \u0441\u043e\u043e\u0431\u0449\u0435\u043d\u0438\u044f?","searching":"\u041f\u043e\u0438\u0441\u043a...","from":"\u041e\u0442","to":"\u041a\u043e\u043c\u0443"});
    rcmail.register_button('logout', 'rcmbtn101', 'link', '', '', '');
    rcmail.register_button('mail', 'rcmbtn102', 'link', '', 'button-mail button-selected', '');
    rcmail.register_button('addressbook', 'rcmbtn103', 'link', '', 'button-addressbook button-selected', '');
    rcmail.register_button('settings', 'rcmbtn104', 'link', '', 'button-settings button-selected', '');
    rcmail.register_button('logout', 'rcmbtn105', 'link', '', 'button-logout', '');
    rcmail.register_button('checkmail', 'rcmbtn106', 'link', 'button checkmail', 'button checkmail pressed', '');
    rcmail.register_button('compose', 'rcmbtn107', 'link', 'button compose', 'button compose pressed', '');
    rcmail.register_button('reply', 'rcmbtn108', 'link', 'button reply', 'button reply pressed', '');
    rcmail.register_button('reply-all', 'rcmbtn109', 'link', 'button reply-all', 'button reply-all pressed', '');
    rcmail.register_button('forward', 'rcmbtn110', 'link', 'button forward', 'button forward pressed', '');
    rcmail.register_button('delete', 'rcmbtn111', 'link', 'button delete', 'button delete pressed', '');
    rcmail.register_button('forward-inline', 'rcmbtn112', 'link', 'forwardlink active', '', '');
    rcmail.register_button('forward-attachment', 'rcmbtn113', 'link', 'forwardattachmentlink active', '', '');
    rcmail.register_button('reply-all', 'rcmbtn114', 'link', 'replyalllink active', '', '');
    rcmail.register_button('reply-list', 'rcmbtn115', 'link', 'replylistlink active', '', '');
    rcmail.register_button('print', 'rcmbtn116', 'link', 'icon active', '', '');
    rcmail.register_button('download', 'rcmbtn117', 'link', 'icon active', '', '');
    rcmail.register_button('edit', 'rcmbtn118', 'link', 'icon active', '', '');
    rcmail.register_button('viewsource', 'rcmbtn119', 'link', 'icon active', '', '');
    rcmail.register_button('open', 'rcmbtn120', 'link', 'icon active', '', '');
    rcmail.register_button('mark', 'rcmbtn121', 'link', 'icon active', '', '');
    rcmail.register_button('mark', 'rcmbtn122', 'link', 'icon active', '', '');
    rcmail.register_button('mark', 'rcmbtn123', 'link', 'icon active', '', '');
    rcmail.register_button('mark', 'rcmbtn124', 'link', 'icon active', '', '');
    rcmail.gui_object('mailboxlist', 'mailboxlist');
    rcmail.gui_object('search_filter', 'rcmlistfilter');
    rcmail.gui_object('qsearchbox', 'quicksearchbox');
    rcmail.register_button('reset-search', 'searchreset', 'link', '', '', '');
    rcmail.gui_object('messagelist', 'messagelist');
    rcmail.gui_object('countdisplay', 'rcmcountdisplay');
    rcmail.register_button('firstpage', 'rcmbtn125', 'link', 'button firstpage', 'button firstpage pressed', '');
    rcmail.register_button('previouspage', 'rcmbtn126', 'link', 'button prevpage', 'button prevpage pressed', '');
    rcmail.register_button('nextpage', 'rcmbtn127', 'link', 'button nextpage', 'button nextpage pressed', '');
    rcmail.register_button('lastpage', 'rcmbtn128', 'link', 'button lastpage', 'button lastpage pressed', '');
    rcmail.gui_object('message', 'message');
    rcmail.register_button('move', 'rcmbtn129', 'link', 'active', '', '');
    rcmail.register_button('copy', 'rcmbtn130', 'link', 'active', '', '');
    rcmail.register_button('expunge', 'rcmbtn131', 'link', 'active', '', '');
    rcmail.register_button('purge', 'rcmbtn132', 'link', 'active', '', '');
    rcmail.register_button('settings.folders', 'rcmbtn134', 'link', 'active', '', '');
    rcmail.register_button('select-all', 'rcmbtn135', 'link', 'icon active', '', '');
    rcmail.register_button('select-all', 'rcmbtn136', 'link', 'icon active', '', '');
    rcmail.register_button('select-all', 'rcmbtn137', 'link', 'icon active', '', '');
    rcmail.register_button('select-all', 'rcmbtn138', 'link', 'icon active', '', '');
    rcmail.register_button('select-all', 'rcmbtn139', 'link', 'icon active', '', '');
    rcmail.register_button('select-none', 'rcmbtn140', 'link', 'icon active', '', '');
    rcmail.register_button('expand-all', 'rcmbtn141', 'link', 'icon active', '', '');
    rcmail.register_button('expand-unread', 'rcmbtn142', 'link', 'icon active', '', '');
    rcmail.register_button('collapse-all', 'rcmbtn143', 'link', 'icon active', '', '');
    rcmail.register_button('menu-save', 'listmenusave', 'input', '', '', '');
    rcmail.register_button('menu-open', 'listmenucancel', 'input', '', '', '');
    rcmail.gui_object('importform', 'uploadformFrm');
    rcmail.register_button('import-messages', 'rcmbtn144', 'input', '', '', '');
</script>

<div id="mainscreen">

    <!-- toolbar -->
    <div id="messagetoolbar" class="toolbar">
        <a class="button checkmail" title="Доставить почту" id="rcmbtn106" href="#"
           onclick="return rcmail.command('checkmail','',this,event)">Обновить</a>
        <a class="button compose" title="Новое сообщение" id="rcmbtn107" href="./?_task=mail&amp;_action=compose"
           onclick="return rcmail.command('compose','',this,event)">Написать сообщение</a>
        <span class="spacer"></span>
        <a class="button reply disabled" title="Ответить" id="rcmbtn108" href="#"
           onclick="return rcmail.command('reply','',this,event)">Ответить</a>
<span class="dropbutton">
	<a class="button reply-all disabled" title="Ответить всем" id="rcmbtn109" href="#"
       onclick="return rcmail.command('reply-all','',this,event)">Ответить всем</a>
	<span class="dropbuttontip" id="replyallmenulink" onclick="UI.show_popup('replyallmenu');return false"></span>
</span>
<span class="dropbutton">
	<a class="button forward disabled" title="Переслать" id="rcmbtn110" href="#"
       onclick="return rcmail.command('forward','',this,event)">Переслать</a>
	<span class="dropbuttontip" id="forwardmenulink" onclick="UI.show_popup('forwardmenu');return false"></span>
</span>
        <a class="button delete disabled" title="Переместить сообщение в корзину" id="rcmbtn111" href="#"
           onclick="return rcmail.command('delete','',this,event)">Удалить</a>

        <a id="markmessagemenulink" class="button markmessage" title="Пометить сообщения"
           onclick="UI.show_popup('markmessagemenu');return false" href="#">Пометить</a>
        <a id="messagemenulink" class="button more" title="Дополнительные действия..."
           onclick="UI.show_popup('messagemenu');return false" href="#">Еще</a>

        <div id="forwardmenu" class="popupmenu">
            <ul class="toolbarmenu">
                <li><a class="forwardlink" id="rcmbtn112" href="#"
                       onclick="return rcmail.command('forward-inline','sub',this,event)">Переслать в теле письма</a>
                </li>
                <li><a class="forwardattachmentlink" id="rcmbtn113" href="#"
                       onclick="return rcmail.command('forward-attachment','sub',this,event)">Переслать как вложение</a>
                </li>

            </ul>
        </div>

        <div id="replyallmenu" class="popupmenu">
            <ul class="toolbarmenu">
                <li><a class="replyalllink" id="rcmbtn114" href="#"
                       onclick="return rcmail.command('reply-all','sub',this,event)">Ответить всем</a></li>
                <li><a class="replylistlink" id="rcmbtn115" href="#"
                       onclick="return rcmail.command('reply-list','sub',this,event)">Ответить в список рассылки</a>
                </li>

            </ul>
        </div>

        <div id="messagemenu" class="popupmenu">
            <ul class="toolbarmenu iconized">
                <li><a class="icon" id="rcmbtn116" href="#" onclick="return rcmail.command('print','',this,event)"><span
                            class="icon print">Печать</span></a></li>
                <li><a class="icon" id="rcmbtn117" href="#"
                       onclick="return rcmail.command('download','',this,event)"><span class="icon download">Сохранить (.eml)</span></a>
                </li>
                <li><a class="icon" id="rcmbtn118" href="#"
                       onclick="return rcmail.command('edit','new',this,event)"><span class="icon edit">Редактировать как новое</span></a>
                </li>
                <li><a class="icon" id="rcmbtn119" href="#" onclick="return rcmail.command('viewsource','',this,event)"><span
                            class="icon viewsource">Исходный текст</span></a></li>
                <li><a target="_blank" class="icon" id="rcmbtn120" href="#"
                       onclick="return rcmail.command('open','',this,event)"><span class="icon extwin">Открыть в новом окне</span></a>
                </li>

            </ul>
        </div>

        <div id="markmessagemenu" class="popupmenu">
            <ul class="toolbarmenu iconized">
                <li><a class="icon" id="rcmbtn121" href="#"
                       onclick="return rcmail.command('mark','read',this,event)"><span
                            class="icon read">Как прочитанное</span></a></li>
                <li><a class="icon" id="rcmbtn122" href="#" onclick="return rcmail.command('mark','unread',this,event)"><span
                            class="icon unread">Как непрочитанное</span></a></li>
                <li><a class="icon" id="rcmbtn123" href="#"
                       onclick="return rcmail.command('mark','flagged',this,event)"><span class="icon flagged">Установить флаг</span></a>
                </li>
                <li><a class="icon" id="rcmbtn124" href="#"
                       onclick="return rcmail.command('mark','unflagged',this,event)"><span class="icon unflagged">Снять флаг</span></a>
                </li>

            </ul>
        </div>

    </div>

    <div id="mailview-left" style="width: 220px;">

        <!-- folders list -->
        <div id="folderlist-header"></div>
        <div id="mailboxcontainer" class="uibox listbox">
            <div id="folderlist-content" class="scroller withfooter">
                <ul id="mailboxlist" class="treelist listing">
                    <li id="rcmliSU5CT1g" class="mailbox inbox selected"><a href="./?_task=mail&amp;_mbox=INBOX"
                                                                            onclick="return rcmail.command('list','INBOX',this)"
                                                                            rel="INBOX">Входящие</a>
                    </li>
                    <li id="rcmliSU5CT1guRHJhZnRz" class="mailbox drafts"><a href="./?_task=mail&amp;_mbox=INBOX.Drafts"
                                                                             onclick="return rcmail.command('list','INBOX.Drafts',this)"
                                                                             rel="INBOX.Drafts">Черновики</a>
                    </li>
                    <li id="rcmliSU5CT1guU2VudA" class="mailbox sent"><a href="./?_task=mail&amp;_mbox=INBOX.Sent"
                                                                         onclick="return rcmail.command('list','INBOX.Sent',this)"
                                                                         rel="INBOX.Sent">Отправленные</a>
                    </li>
                    <li id="rcmliSU5CT1guVHJhc2g" class="mailbox trash"><a href="./?_task=mail&amp;_mbox=INBOX.Trash"
                                                                           onclick="return rcmail.command('list','INBOX.Trash',this)"
                                                                           rel="INBOX.Trash">Корзина</a>
                    </li>
                </ul>

            </div>
            <div id="folderlist-footer" class="boxfooter">
                <a id="mailboxmenulink" title="Операции над папкой..." class="listbutton groupactions"
                   onclick="UI.show_popup('mailboxmenu');return false" href="#"><span class="inner">⚙</span></a>
            </div>
        </div>

    </div>

    <div id="mailview-right" style="left: 232px;">

        <div id="messagesearchtools">

            <!-- search filter -->
            <div id="searchfilter">
                <select name="searchfilter" class="searchfilter decorated" id="rcmlistfilter"
                        onchange="rcmail.filter_mailbox(this.value)" style="width: 147px;">
                    <option value="ALL">Все</option>
                    <option value="UNSEEN">Непрочитанные</option>
                    <option value="FLAGGED">Помеченные</option>
                    <option value="UNANSWERED">Неотвеченные</option>
                    <option value="DELETED">Удаленные</option>
                    <option value="UNDELETED">Не удаленные</option>
                    <option
                        value=" OR OR OR HEADER Content-Type application/ HEADER Content-Type multipart/m HEADER Content-Type multipart/signed HEADER Content-Type multipart/report">
                        С вложением
                    </option>
                    <option value="HEADER X-PRIORITY 1">Приоритет: Высоч.</option>
                    <option value="HEADER X-PRIORITY 2">Приоритет: Высокий</option>
                    <option
                        value="NOT HEADER X-PRIORITY 1 NOT HEADER X-PRIORITY 2 NOT HEADER X-PRIORITY 4 NOT HEADER X-PRIORITY 5">
                        Приоритет: Норм.
                    </option>
                    <option value="HEADER X-PRIORITY 4">Приоритет: Низкий</option>
                    <option value="HEADER X-PRIORITY 5">Приоритет: Низший</option>
                </select><a class="menuselector" style="position: absolute; top: 0px; left: 0px;"><span class="handle"
                                                                                                        style="width: 109px; height: 24px; line-height: 23px;">Все</span></a>

            </div>

            <!-- search box -->
            <div id="quicksearchbar" class="searchbox">
                <form name="rcmqsearchform" onsubmit="rcmail.command('search'); return false" style="display:inline"
                      action="./?_task=mail" method="get"><input name="_q" id="quicksearchbox" type="text"></form>

                <a id="searchmenulink" class="iconbutton searchoptions"
                   onclick="UI.show_popup('searchmenu');return false" title="Варианты поиска" href="#"> </a>
                <a id="searchreset" class="iconbutton reset" title="Сброс" href="#"
                   onclick="return rcmail.command('reset-search','',this,event)"> </a>
            </div>

        </div>

        <div id="mailview-top" class="uibox fullheight">

            <!-- messagelist -->
            <div id="messagelistcontainer" class="boxlistcontent">
                <table class="records-table messagelist sortheader fixedheader fixedcopy"
                       style="position: fixed; width: 1363px;">
                    <thead>
                    <tr>
                        <td class="threads" id="rcmthreads" style="width: 30px;">
                            <div onclick="return rcmail.command('menu-open', 'messagelistmenu')" class="listmenu"
                                 id="listmenulink" title="Настройки списка..."></div>
                        </td>
                        <td class="subject" id="rcmsubject" style="width: 830px;"><a href="./#sort"
                                                                                     onclick="return rcmail.command('sort','subject',this)"
                                                                                     title="Сортировать по">Тема</a>
                        </td>
                        <td class="status" id="rcmstatus" style="width: 26px;"><span class="status">&nbsp;</span></td>
                        <td class="fromto" id="rcmfromto" style="width: 200px;"><a href="./#sort"
                                                                                   onclick="return rcmail.command('sort','fromto',this)"
                                                                                   title="Сортировать по">От</a></td>
                        <td class="date" id="rcmdate" style="width: 135px;"><a href="./#sort"
                                                                               onclick="return rcmail.command('sort','date',this)"
                                                                               title="Сортировать по">Дата</a></td>
                        <td class="size" id="rcmsize" style="width: 60px;"><a href="./#sort"
                                                                              onclick="return rcmail.command('sort','size',this)"
                                                                              title="Сортировать по">Размер</a></td>
                        <td class="flag" id="rcmflag" style="width: 26px;"><span class="flagged">&nbsp;</span></td>
                        <td class="attachment" id="rcmattachment" style="width: 26px;"><span
                                class="attachment">&nbsp;</span></td>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <table id="messagelist" class="records-table messagelist sortheader fixedheader">
                    <thead>
                    <tr>
                        <td class="threads" id="rcmthreads" style="">
                            <div onclick="return rcmail.command('menu-open', 'messagelistmenu')" class="listmenu"
                                 id="listmenulink" title="Настройки списка..."></div>
                        </td>
                        <td class="subject" id="rcmsubject" style=""><a href="./#sort"
                                                                        onclick="return rcmail.command('sort','subject',this)"
                                                                        title="Сортировать по">Тема</a></td>
                        <td class="status" id="rcmstatus" style=""><span class="status">&nbsp;</span></td>
                        <td class="fromto" id="rcmfromto" style=""><a href="./#sort"
                                                                      onclick="return rcmail.command('sort','fromto',this)"
                                                                      title="Сортировать по">От</a></td>
                        <td class="date" id="rcmdate" style=""><a href="./#sort"
                                                                  onclick="return rcmail.command('sort','date',this)"
                                                                  title="Сортировать по">Дата</a></td>
                        <td class="size" id="rcmsize" style=""><a href="./#sort"
                                                                  onclick="return rcmail.command('sort','size',this)"
                                                                  title="Сортировать по">Размер</a></td>
                        <td class="flag" id="rcmflag" style=""><span class="flagged">&nbsp;</span></td>
                        <td class="attachment" id="rcmattachment" style=""><span class="attachment">&nbsp;</span></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr id="rcmrow2" class="message">
                        <td class="threads"></td>
                        <td class="subject"><span id="msgicn2" class="msgicon replied">&nbsp;</span><a
                                href="./?_task=mail&amp;_action=show&amp;_mbox=INBOX&amp;_uid=2"
                                onclick="return rcube_event.cancel(event)"
                                onmouseover="rcube_webmail.long_subject_title(this,1)">супертест</a></td>
                        <td class="status"><span id="statusicn2" class="msgicon">&nbsp;</span></td>
                        <td class="fromto"><span class="adr"><span title="radiophysic@gmail.com"
                                                                   class="rcmContactAddress">Kirill Govina</span></span>
                        </td>
                        <td class="date">Пт 16:10</td>
                        <td class="size">2 КБ</td>
                        <td class="flag"><span id="flagicn2" class="unflagged">&nbsp;</span></td>
                        <td class="attachment">&nbsp;</td>
                    </tr>
                    <tr id="rcmrow1" class="message">
                        <td class="threads"></td>
                        <td class="subject"><span id="msgicn1" class="msgicon">&nbsp;</span><a
                                href="./?_task=mail&amp;_action=show&amp;_mbox=INBOX&amp;_uid=1"
                                onclick="return rcube_event.cancel(event)"
                                onmouseover="rcube_webmail.long_subject_title(this,1)">Re: test 4</a></td>
                        <td class="status"><span id="statusicn1" class="msgicon">&nbsp;</span></td>
                        <td class="fromto"><span class="adr"><span title="radiophysic@gmail.com"
                                                                   class="rcmContactAddress">Kirill Govina</span></span>
                        </td>
                        <td class="date">Чт 20:43</td>
                        <td class="size">4 КБ</td>
                        <td class="flag"><span id="flagicn1" class="unflagged">&nbsp;</span></td>
                        <td class="attachment">&nbsp;</td>
                    </tr>
                    </tbody>
                </table>

            </div>

            <!-- list footer -->
            <div id="messagelistfooter">
                <div id="listcontrols">
                    <a href="#list" class="iconbutton listmode selected" id="maillistmode" title="Список">List</a>
                    <a href="#threads" class="iconbutton threadmode" id="mailthreadmode" title="Обсуждения">Threads</a>

                </div>

                <div id="listselectors">
                    <a href="#select" id="listselectmenulink" class="menuselector"
                       onclick="UI.show_popup('listselectmenu');return false"><span class="handle">Выбрать</span></a>
                    &nbsp; <a href="#threads" id="threadselectmenulink" class="menuselector"
                              onclick="UI.show_popup('threadselectmenu');return false"><span
                            class="handle">Обсуждения</span></a>
                </div>

                <div id="countcontrols" class="pagenav dark">
                    <span class="countdisplay" id="rcmcountdisplay">Сообщения с 1 по 2 из 2</span>
		<span class="pagenavbuttons">
		<a class="button firstpage disabled" title="Показать первую страницу" id="rcmbtn125" href="#"
           onclick="return rcmail.command('firstpage','',this,event)"><span class="inner">|&lt;</span></a>
		<a class="button prevpage disabled" title="Показать предыдущую страницу" id="rcmbtn126" href="#"
           onclick="return rcmail.command('previouspage','',this,event)"><span class="inner">&lt;</span></a>
		<a class="button nextpage disabled" title="Показать следующую страницу" id="rcmbtn127" href="#"
           onclick="return rcmail.command('nextpage','',this,event)"><span class="inner">&gt;</span></a>
		<a class="button lastpage disabled" title="Показать последнюю страницу" id="rcmbtn128" href="#"
           onclick="return rcmail.command('lastpage','',this,event)"><span class="inner">&gt;|</span></a>
		</span>
                </div>


                <a href="#preview" id="mailpreviewtoggle" title="Показать панель превью" class="closed"></a>
            </div>

        </div>
        <!-- end mailview-top -->

        <div id="mailview-bottom" class="uibox">

            <!--            <div id="mailpreviewframe" class="iframebox">-->
            <!--                <iframe name="messagecontframe" id="messagecontframe" style="width:100%; height:100%" frameborder="0" src="skins/larry/watermark.html"></iframe>-->
            <!--            </div>-->

            <div id="message" class="statusbar"></div>

        </div>
        <!-- end mailview-bottom -->

    </div>
    <!-- end mailview-right -->

    <div id="mailviewsplitterv" unselectable="on" class="splitter splitter-v" style="left: 223px; top: 0px;"></div>
</div>

<script type="text/javascript">

    // UI startup
//    var UI = new rcube_mail_ui();
//    console.log(UI);
//    $(document).ready(function(){
//        UI.set('errortitle', 'Произошла ошибка!');
//        UI.init();
//    });

</script>
<!--[if lte IE 8]>
<script type="text/javascript">

    // fix missing :last-child selectors
    $(document).ready(function(){
        $('ul.treelist ul').each(function(i,ul){
            $('li:last-child', ul).css('border-bottom', 0);
        });
    });

</script>
<![endif]-->



<script type="text/javascript">

    jQuery.extend(jQuery.ui.dialog.prototype.options.position, {
        using: function(pos) {
            var me = jQuery(this),
                offset = me.css(pos).offset(),
                topOffset = offset.top - 12;
            if (topOffset < 0)
                me.css('top', pos.top - topOffset);
            if (offset.left + me.outerWidth() + 12 > jQuery(window).width())
                me.css('left', pos.left - 12);
        }
    });
//    $(document).ready(function(){
//        rcmail.init();
//    });
</script>

</body>
</html>