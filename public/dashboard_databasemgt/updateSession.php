<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selectedTab'], $_POST['selectedPage'])) {
    $selectedTab = $_POST['selectedTab'];
    $selectedPage = $_POST['selectedPage'];

    switch($selectedPage) {
        case 'research':
            $_SESSION['selectedResearch'] = $selectedTab;
            break;
        case 'home':
            $_SESSION['selectedHome'] = $selectedTab;
            break;
        case 'team':
            $_SESSION['selectedTeam'] = $selectedTab;
            break;
        case 'events':
            $_SESSION['selectedEvents'] = $selectedTab;
            break;
        case 'engagements':
            $_SESSION['selectedEngagements'] = $selectedTab;
            break;
    }

    // Store general values if needed
    $_SESSION['selectedTab'] = $selectedTab;
    $_SESSION['selectedPage'] = $selectedPage;

    echo json_encode([
        'status' => 'success',
        'selectedTab' => $selectedTab,
        'selectedPage' => $selectedPage
    ]);
    exit;
}

?>