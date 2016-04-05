<?
  $login = $this->data['main']['login'];
  $health = $this->data['main']['point']['health'];
  $cash = $this->data['main']['point']['cash'];
?>
<!-- панель игрока --> 
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
         <a  href="/user" class="brand"><?=$login?></a>
          <div style="height: 0px;" class="nav-collapse collapse">
            <!-- шкала жизней -->
            <div class="nav navbar-text progress progress-success progress-striped active" style="width: 300px; margin-top:10px">
                <div class="bar" <?="style='width: ".$health."%;'"?>></div>
            </div>
            <!-- шкала жизней -->
            <ul class="nav">
              <!-- монеты -->
              <li><a class="navbar-brand" href="/user/top"> <img src="/img/coin_icon.png" class="img-circle"> x <?=$cash?></a></li>
              <!-- монеты -->
              <!-- рюкзак -->
              <li><a href="/user/backpack">Рюкзак</a></li>
              <!-- рюкзак -->
              <!-- события -->
              <!-- события -->
            </ul>
            <p class="navbar-text pull-right">
              <a data-toggle="modal" href="#myModal" class="btn">Об игре</a>
              <a href="/user/exit" class="btn btn-inverse">Выйти</a>
            </p>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

  <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h3 id="myModalLabel">Игра "Акционер"</h3>
    </div>
    <div class="modal-body">
      <h4>Цель игры</h4>
      <p>Осуществлять торговые операции с акциями, добиться превышения своего капитала над капиталом соперника или соперников. Каждый игрок, начинающий партию с первоначальным капиталом, стремится максимально его увеличить, препятствуя при этом росту капитала соперников.</p>
      <hr>

      <h4>Профиль</h4>
      <p>В профиле представлена основная информация о игроке.</p>

      <h4>Общение</h4>
      <p>Простой хэндмэк чат. Предназначен для общения игроков.</p>

      <h4>ТОП 10</h4>
      <p>Информация о самых сильных игроках.</p>

      <h4>Игроки</h4>
      <p>Информация о всех игроках.</p>

      <h4>Обратная связь</h4>
      <p>Здесь можно оставить комментарии, замечания или предложения о игре. </p>

      <h4>Компании</h4>
      <p>Здесь представлены основные компании игры, с которыми игроки могут совершать покупку/продажу акций.
       Компании обладают именем , статусом и другими атрибутами. Статус компании определяет возможность взаимодействия с клиентами (Вами): 
       <strong>worked</strong> - работает, с ней можно взаимодействовать.
       <strong>defaulter</strong> - банкрот, с ней невозможно взаимодействовать.
      </p>
      <h4>Магазин</h4>
      <p>В магазине можно приобрести различные предметы. После покупки предмет появится у Вас в рюкзаке.</p>
      <h4>Работа</h4>
      <p>Игрок может устроиться на работу, чтобы повысить свою классификацию или доход.(<b class="text-error">Раздел не работает!</b>)</p>

       <b>Игру разработал Шамсиев Ильнур</b>
       <h6>vk: vk.com/id139707777</h6>
       <h6>email: lunetcool@gmail.com</h6>

    </div>
    <div class="modal-footer">
      <button class="btn" data-dismiss="modal">Close</button>
    </div>
  </div>
<!-- панель игрока -->  