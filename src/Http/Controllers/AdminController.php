<?php

use App\Http\Controllers\Controller;
use App\Login\Login;
use App\Login\LoginSocial;
use App\Core\Request;
use App\Http\Controllers\Helper\AuthHelper;
use App\User\UserChartData;

class AdminController extends Controller
{
    use Request;
    use AuthHelper;

    public function __construct(
        private readonly string $methodName,
        private readonly mixed $parameters = null,
        private readonly Login $login = new Login(),
        private readonly LoginSocial $loginSocial = new LoginSocial()
    ) {
        parent::__construct();
        $this->checkAuth(methodName: $methodName, parameters: $parameters);
    }

    public function index(): void
    {
        $usersData = new UserChartData();

        $this->view->render(filename: 'admin/dashboard/index', data:
            [
                'new_users' => $usersData->getNewUsersFromLastDays()
            ]
        );
    }

}