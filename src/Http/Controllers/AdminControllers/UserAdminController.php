<?php

use App\Http\Controllers\Controller;
use App\Login\Login;
use App\Login\LoginSocial;
use App\Core\Request;
use App\Http\Controllers\Helper\AuthHelper;

class UserAdminController extends Controller
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
        $this->view->render(filename: 'admin/user/index');
    }

    public function userOrder(mixed ...$parameters): void
    {
        $this->view->render(filename: 'admin/user/order', data:
            [
                'orderID' => $parameters
            ]
        );
    }

    public function userOrders(): void
    {
        $this->view->render(filename: 'admin/user/order');
    }

    public function userCoupons(): void
    {
        $this->view->render(filename: 'admin/user/coupons');
    }

    public function userAddCoupon(mixed ...$parameters): void
    {
        $this->view->render(filename: 'admin/user/addCoupon', data:
            [
                'userID' => $parameters
            ]
        );
    }

    public function userEditCoupon(): void
    {
        $this->view->render(filename: 'admin/users/editCoupon');
    }
}