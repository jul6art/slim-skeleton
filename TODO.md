### V1 skeleton

https://demo.dashboardpack.com/architectui-html-free/index.html

- theme backoffice
    + translations layout
    + datatables simples non ajax (+ export etc) 
- users 
    register and reset password
        + recaptcha
        + respect validation and unique email assert
        + revoir gestion forms et tester injection
        + avatar
            afficher avatar, menu user et change locale dans menu et menu responsive
    roles + annotations granted ou voter (+ abstractcontroller gettoken isgranted denyacces ...)
- pages d erreur
- corriger firewall
- abstract crud et crud users
- settings page (ou sidebar avec switches) avec helpers twig et service trait pour recupérer les settings
- batterie de tests et coverage
        
- forker pour devinthehood
    pas de page about
    seulement les projects dont t'es fier mon gars et les autres, tu COUPES
        mettre compétences en avant
            symfony
            flex
            laravel
            wordpress
            prestashop
            jenkins
            ....
        mettre projets en avant: enoprimes, myenergy, cashlib, provencale, bccl, 
    + déployer
    + migrer tout vsweb (signature email, CV linkedin, ...)
    
sources
-------

https://github.com/llvdl/Slim-Translations-Example/blob/master/app/config/routes.php

https://colorlib.com/preview/theme/martin/index.html#
https://huge-demo.krownthemeswp.com/
https://madsparrow.me/emily/index.html
https://www.mockplus.com/blog/post/css-animation-examples

https://github.com/HavenShen/slim-born/blob/master/app/Models/Entity.php
https://github.com/jeremykendall/slim-auth
https://discourse.slimframework.com/t/slim-framework-3-skeleton-application-has-authentication-mvc-construction/2088
