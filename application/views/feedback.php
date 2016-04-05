<!-- основной контент -->
<div class='container'>
    <div id='content' class='row-fluid'>
        <div class='span12 sidebar'>
            <ul class="nav  nav-pills" >
                <li><a href='/user'>Профиль</a></li>
                <li><a href='/user/chat'>Общение</a></li>
                <li><a href='/user/top'>ТОП 10</a></li>
                <li><a href='/user/all'>Игроки</a></li>
                <li class="active"><a href='/user/feedback'>Обратная связь</a></li>
                <li><a href='/area/companies'>Компании</a></li>
                <li><a href='/area/shop'>Магазин</a></li>
                <li><a href='/area/storage'>Банк</a></li>
                <li><a href='/area/work'>Работа</a></li>
            </ul>
        </div>
    </div>
</div>

<div class='container' id="content">
    <div class="row">
        <div class="span12">
        <p>Воспользуйтесь формой, чтобы задать интересующий Вас вопрос, отправить комментарии, замечания или предложения. </p>
            <form method="POST" action="">
                <div class="controls">
                    <textarea id="message" name="message" class="span12" placeholder="Your Message" rows="5"></textarea>
                </div>
                <div class="form-actions">
                    <button  type="submit" class="btn btn-primary input-large">Отправить</button>
                </div>
            </form>
            <?
                //var_dump($this->data['fed_msg']);
                foreach ($this->data['fed_msg'] as $item ) {
                    $id = $item['id'];
                    $msg = $item['msg'];
                    echo <<<LABEL
                        <hr>
                        <h4>Запись #$id</h4>
                        <p>$msg</p>
LABEL;
                }
            ?>
            <div id="alert_placeholder"></div>
        </div>
    </div>
</div>
<!-- основной контент -->