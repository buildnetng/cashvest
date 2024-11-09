<?php

if (isset($_SERVER["REDIRECT_URL"])) {
    $url = basename($_SERVER["REDIRECT_URL"]);
} else {
    $url = "home";
}

require_once "config/config.php";

switch ($url) {
    case 'sign-in':
        $title = 'Sign In';
        require __DIR__ . '/src/views/public/sign-in.php';
        break;

    case 'sign-up':
        $title = 'Sign Up';
        require __DIR__ . '/src/views/public/sign-up.php';
        break;

    case 'reset-password':
        $title = 'Reset Password';
        require __DIR__ . '/src/views/public/reset-password.php';
        break;

    case 'reset-new-password':
        $title = 'New Password';
        require __DIR__ . '/src/views/public/reset-new-password.php';
        break;

    case 'verify-email':
        $title = 'Verify Email';
        require __DIR__ . '/src/views/public/verify-email.php';
        break;

    case 'verify-email-token':
        $title = 'Verify Email Token';
        require __DIR__ . '/src/views/public/verify-email-token.php';
        break;

    case 'sign-out':
        $title = 'Sign Out';
        require __DIR__ . '/src/views/public/sign-out.php';
        break;
        // user routes
    case '':
    case 'home':
    case 'dashboard':
        $title = 'User Dashboard';
        require __DIR__ . '/src/views/user/index.php';
        break;

    case 'analysis':
        $title = 'Analysis';
        require __DIR__ . '/src/views/user/analysis.php';
        break;

    case 'deposit':
        $title = 'Deposit';
        require __DIR__ . '/src/views/user/deposit.php';
        break;

        case 'upload':
            $title = 'Upload';
            require __DIR__ . '/src/views/user/upload.php';
            break;

    case 'history':
        $title = 'History';
        require __DIR__ . '/src/views/user/history.php';
        break;

    case 'info':
        $title = 'Information';
        require __DIR__ . '/src/views/user/info.php';
        break;

    case 'loan':
        $title = 'Loan';
        require __DIR__ . '/src/views/user/loan.php';
        break;

    case 'marketplace':
        $title = 'Marketplace';
        require __DIR__ . '/src/views/user/marketplace.php';
        break;

    case 'setting':
        $title = 'Setting';
        require __DIR__ . '/src/views/user/setting.php';
        break;

    case 'profile':
        $title = 'Profile';
        require __DIR__ . '/src/views/user/profile.php';
        break;

    case 'referral':
        $title = 'Referral';
        require __DIR__ . '/src/views/user/referral.php';
        break;

    case 'service':
        $title = 'Service';
        require __DIR__ . '/src/views/user/service.php';
        break;

    case 'shares':
        $title = 'Shares';
        require __DIR__ . '/src/views/user/shares.php';
        break;

    case 'withdrawal':
        $title = 'Withdrawal';
        require __DIR__ . '/src/views/user/withdrawal.php';
        break;

    case 'support':
        $title = 'Support';
        require __DIR__ . '/src/views/user/support.php';
        break;

        // Admin routes
    case 'admin':
        $title = 'Admin Dashboard';
        require __DIR__ . '/src/views/admin/index.php';
        break;

    case 'users':
        $title = 'User Management';
        require __DIR__ . '/src/views/admin/users.php';
        break;

    case 'deposits':
        $title = 'Deposits';
        require __DIR__ . '/src/views/admin/deposits.php';
        break;

    case 'withdrawals':
        $title = 'Withdrawals';
        require __DIR__ . '/src/views/admin/withdrawal.php';
        break;

    case 'tickets':
        $title = 'Support Tickets';
        require __DIR__ . '/src/views/admin/tickets.php';
        break;

    case 'settings':
        $title = 'Admin Settings';
        require __DIR__ . '/src/views/admin/settings.php';
        break;

    case 'system':
        $title = 'System Management';
        require __DIR__ . '/src/views/admin/system.php';
        break;

    case 'send-mail':
        $title = 'Send Mail';
        require __DIR__ . '/src/views/admin/send-mail.php';
        break;

    case 'admin_profile':
        $title = 'Admin Profile';
        require __DIR__ . '/src/views/admin/profile.php';
        break;

    default:
        $title = 'Page not found';
        http_response_code(404);
        require __DIR__ . '/src/views/404.php';
        break;
}
