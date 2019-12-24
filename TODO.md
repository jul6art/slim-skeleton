https://colorlib.com/preview/theme/martin/index.html#

- database eloquent
    https://github.com/illuminate/database
    fixtures
- cache
- users 
    auth
        https://github.com/HavenShen/slim-born/blob/master/app/Models/User.php
        https://discourse.slimframework.com/t/slim-framework-3-skeleton-application-has-authentication-mvc-construction/2088
    login
        https://github.com/jeremykendall/slim-auth
    roles + voter (+ abstractcontroller gettoken isgranted denyacces ...) 
        utiliser routecontext pour appliquer automatiquement le bon voter
            http://www.slimframework.com/docs/v4/cookbook/retrieving-current-route.html
- csrf
- pages d erreur
- swift mailer
- abstract crud et crud users
    form voir validation/assert via respect
    datatables simples non ajax (+ export etc)
    theme backoffice minimaliste 
    theme email

- forker pour devinthehood
    + theme
    + déployer
    + migrer tout vsweb (signature email, linkedin, ...)