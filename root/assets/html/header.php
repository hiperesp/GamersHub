        <div class="header">
            <div class="container">
<?php
if($logged==true){
?>
                <div class="leftLogged">
                    <a href="<?php echo alinks('paginaInicial', null); ?>">
                        <h1 class="title siteTitle"><span>Gamers</span><span class="siteColor">Hub</span></h1>
                    </a>
                </div>
				<div class="right">
					<a href="<?php echo alinks('profile', $steamprofile['steamid']); ?>">
						<img class="userimg" src="<?php echo $steamprofile['avatarmedium']; ?>" height="50">
						<p class="username" title="Meu perfil"><?php echo $steamprofile['personaname']; ?></p>
					</a>
					<a class="topbartext" href="<?php echo alinks('logout', null); ?>">
						<h4>Sair</h4>
					</a>
				</div>
<?php
}
?>
				<div class="rightMenu">
					<a href="javascript:void(0)" id="hamburgerButton">
						<h1 class="title siteTitle">&#9776;</h1>
					</a>
				</div>
<?php
if($logged!=true){
?>
                <div class="left" style="width:100px;height:1px;"></div>
                <div class="center">
                    <a href="<?php echo alinks('paginaInicial', null); ?>">
                        <h1 class="title siteTitle"><span>Gamers</span><span class="siteColor">Hub</span></h1>
                    </a>
                </div>
                <div class="right">
					<a href="<?php echo alinks('login', null); ?>">
						<img class="signIn" src="https://steamcommunity-a.akamaihd.net/public/images/signinthroughsteam/sits_01.png">
					</a>
				</div>
<?php
}
?>
            </div>
        </div>
		<div class="hamburgerMenu" id="hamburgerMenu">
			<ul>
<?php
if($logged==true){
?>
				<li>
					<a href="<?php echo alinks('profile', $steamprofile['steamid']); ?>">
						<p class="username"><?php echo $steamprofile['personaname']; ?></p>
					</a>
				</li>
<?php
} else {
?>
				<li>
					<a href="<?php echo alinks('login', null); ?>">
						<p class="username">Sign in through Steam</p>
						<h6>This site is not associated with Valve Corp.</h6>
					</a>
				</li>
<?php
}
?>
				<li>
					<a href="javascript:void(0)" onclick="javascript:toggleDarkMode();">
						<p class="username toggleDarkMode-Dark">Modo Noturno</p>
						<p class="username toggleDarkMode-Light">Modo Claro</p>
					</a>
				</li>
<?php
if($logged==true){
?>
				<li>
					<a href="<?php echo alinks('logout', null); ?>">
						<p class="username">Sair</p>
					</a>
				</li>
<?php
}
?>
			</ul>
		</div>