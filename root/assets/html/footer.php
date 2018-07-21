        <div class="footer">
            <div class="container paddingtopcontainer">
                <div class="center">
                    <div>
                        <a href="<?php echo alinks('paginaInicial', null); ?>">
                            <p class="title siteTitle"><span>Página</span><span class="siteColor">Inicial</span></p>
                        </a>
<?php
if($logged==true){
?>
                        <a href="<?php echo alinks('profile', $steamprofile['steamid']); ?>">
                            <p class="title siteTitle"><span>Meu</span><span class="siteColor">Perfil</span></p>
                        </a>
<?php
}
?>
                        <a href="<?php echo alinks('suporte', null); ?>">
                            <p class="title siteTitle"><span>S</span><span class="siteColor">uporte</span></p>
                        </a>
<?php
if($logged==true){
?>
                        <a href="<?php echo alinks('logout', null); ?>">
                            <p class="title siteTitle"><span>S</span><span class="siteColor">air</span></p>
                        </a>
<?php
} else {
?>
                        <a href="<?php echo alinks('login', null); ?>">
                            <p class="title siteTitle"><span>E</span><span class="siteColor">ntrar</span></p>
                        </a>
                        <a href="<?php echo alinks('login', null); ?>">
                            <p class="title siteTitle"><span>C</span><span class="siteColor">adastrar</span></p>
                        </a>
<?php
}
?>
                    </div>
                    <div>
					    <a href="<?php echo alinks('servers', null); ?>">
                            <p class="title siteTitle"><span>Nossos</span><span class="siteColor">Servidores</span></p>
					    </a>
					    <a href="javascript:void(0)" onclick="javascript:toggleDarkMode();">
                            <p class="title siteTitle toggleDarkMode-Dark"><span>Modo</span><span class="siteColor">Noturno</span></p>
                            <p class="title siteTitle toggleDarkMode-Light"><span>Modo</span><span class="siteColor">Claro</span></p>
					    </a>
                    </div>
                    <div>
                        <a href="<?php echo alinks('paginaInicial', null); ?>">
                            <h1 class="title siteTitle"><span>Gamers</span><span class="siteColor">Hub</span><span class="fakeH6"><span> By hiperesp</span></h1>
                        </a>
                    </div>
                    <div>
                        <h6 class="title siteTitle">&copy; 2018. Todos os direitos reservados.</h6>
                    </div>
                </div>
            </div>
        </div>