<?
  $login = $this->data['node']['login'];
  $cash = $this->data['node']['info']['point']['cash'];
  $health = $this->data['node']['info']['point']['health'];
  $status = $this->data['node']['info']['point']['status'];
  $dt = $this->data['node']['info']['datetime'];
  $companies = $this->data['node']['info']['companies'] ;

?>
<div class='container'>
  <div id='content' class='row-fluid'>
    <div class='span12 sidebar'>
      <ul class="nav  nav-pills" >
        <li class="active"><a href='/user'>Профиль</a></li>
        <li><a href='/user/chat'>Общение</a></li>
        <li><a href='/user/top'>ТОП 10</a></li>
        <li><a href='/user/all'>Игроки</a></li>
        <li><a href='/user/feedback'>Обратная связь</a></li>
        <li><a href='/area/companies'>Компании</a></li>
        <li><a href='/area/shop'>Магазин</a></li>
        <li><a href='/area/storage'>Банк</a></li>
        <li><a href='/area/work'>Работа</a></li>
      </ul>
    </div>
  </div>
</div>
<!-- основной контент -->
<div class='container'>
  <div id='content' class='row-fluid'>
       <div class="row">
            <div class="span2 offset1">
              <div style="text-align:center;">
                <span class="imgframe centerimg">
                  <a href=""><img src="/img/no_avatar.png" /><br /></a>
                </span>
              </div>
            </div>
              
            <div class="span8">
            <p><strong>Профиль игрока</strong></p>
              <p>
                  <i class="icon-user"></i> Имя: <?=$login?><br>
                  <i class="icon-heart"></i> HP: <?=$health."%"?><br>
                  <i class="icon-leaf"></i> Капитал: <?=$cash?><br>
                  <i class="icon-star"></i> Статус: <?=$status?><br>
                  <i class="icon-time"></i> Дата регистрации: <?=$dt?><br>
                </p>
              <table class="table table-condensed">
                 <!-- <table class="table table-striped table-bordered table-hover"> -->
                  <thead>
                    <tr>
                      <th>Компания</th>
                      <th>Количество акций</th>
                    </tr>
                  </thead>
                    <tbody>
                     <?
            if(empty($this->errors)){
              foreach($companies as $company){
                $shareCnt = $company['shareCnt'];
                $name = $company['company'];
                echo <<<LABEL
                <tr>
                  <td>$name</td>
                  <td>$shareCnt</td>
                </tr>
LABEL;
              }
            }
          ?>
                    </tbody>
                </table>
                <?=$this->errors['err_msg']?>
             </div>
          </div>
    </div>
</div>

<!-- основной контент -->
