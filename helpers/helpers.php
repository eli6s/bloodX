<?php
date_default_timezone_set('Etc/GMT-3');
// Start the session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$_SESSION['LAYOUT_PATH_FRONTEND'] = '/bloodX/';
$_SESSION['LAYOUT_PATH'] = '/admin/';
$_SESSION['DEFAULT_IMAGE_PATH'] = 'default.png';
$_SESSION['BANNER_SLIDER_IMAGES'] = ['banner1.gif', 'banner2.png', 'banner3.png'];
$_SESSION['PER_PAGE'] = 5;

function asset($path)
{
    if (!isset($path)) {
        return $_SESSION['LAYOUT_PATH_FRONTEND'];
    }

    return $_SESSION['LAYOUT_PATH_FRONTEND'] . $path;
}

function setStatus($status, $id = 0, $user_id = 0)
{
    $cases = [
        'success' => ['active',  'approved', 'completed'],
        'danger'  => ['suspended', 'rejected'],
        'info' => ['inactive'],
        'warning' => ['pending', 'canceled']
    ];

    $statusIcons = [
        'active'    => 'fa-check-circle',  // Icon for active status
        'pending'   => 'fa-clock',          // Icon for pending status
        'inactive'  => 'fa-ban',            // Icon for inactive status
        'approved'  => 'fa-check',      // Icon for approved status
        'completed' => 'fa-check-square',   // Icon for completed status
        'rejected'  => 'fa-times-circle',   // Icon for rejected status
        'canceled'  => 'fa-times-circle',   // Icon for canceled status
        'suspended' => 'fa-ban'    // Icon for suspended status
    ];

    // Check if the status exists in the icon mapping array
    if (array_key_exists($status, $statusIcons)) {
        foreach ($cases as $key => $value) {
            if (in_array(strtolower($status), $value)) {
                if ($status == 'pending') {
                    return '<div class="dropdown">
                            <button class="btn-sm btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-clock"></i></button>
                            <div class="dropdown-menu">
                                <form method="GET" action="contact.php">
                                    <input type="hidden" value="' . $user_id . '" name="user_id"/>
                                    <input type="hidden" value="' . $id . '" name="id"/>
                                    <button type="submit" class="dropdown-item bg-light text-success has-icon"><i class="fas fa-check"></i>Approve</button>
                                </form>
                                <a class="dropdown-item text-danger  has-icon delete-item" href="reject.php" data-id="' . $id . '" data-title="Rejected"><i class="fas fa-times"></i>Reject</a>
                            </div>
                        </div>';
                } elseif ($status == 'approved') {
                    return '<div class="dropdown">
                    <button class="btn-sm btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-clock"></i></button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item text-success has-icon delete-item" href="complete.php" data-id="' . $id . '" data-title="Completed"><i class="fas fa-check"></i>Complete</a>
                        <a class="dropdown-item text-danger  has-icon delete-item" href="cancel.php" data-id="' . $id . '" data-title="Canceled"><i class="fas fa-times"></i>Cancel</a>
                    </div>
                </div>';
                } else {
                    // Render the corresponding icon using Font Awesome
                    return '<span class="badge badge-' . $key . '" data-toggle="tooltip" data-title="' . ucwords($status) . '">
                        <i style="user-select:none" class="fas ' . $statusIcons[$status] . '"></i>
                      </span>';
                }
            }
        }
    } else {
        // Default icon for unknown statuses
        return '<span class="badge badge-secondary" data-toggle="tooltip" data-title="No Status">
        <i style="user-select:none" class="fas fa-question"></i>
      </span>';
    }
}

function old($name)
{
    if (isset($_SESSION['OLD_DATA_FRONTEND'])) {
        if (is_array($_SESSION['OLD_DATA_FRONTEND'])) {
            return $_SESSION['OLD_DATA_FRONTEND'][$name];
        }
        return htmlspecialchars($_SESSION['OLD_DATA_FRONTEND'][$name]);
    } else {
        return '';
    }
}

function isExistsDB($name, $field = 'email', $isSpecific = false, $id = 0)
{
    global $conn; // Access the global $conn variable
    $validFields = ['email', 'username']; // fields needed to check

    if (!in_array($field, $validFields)) {
        // Field is not valid, return false
        return false;
    }

    if ($isSpecific) {
        $query = "SELECT COUNT(*) AS users_count FROM users WHERE $field = ? and user_id != $id";
    } else {
        $query = "SELECT COUNT(*) AS users_count FROM users WHERE $field = ?";
    }

    $stmt = $conn->prepare($query);
    $stmt->execute([$name]);
    $result = $stmt->fetchColumn();

    return $result > 0;
}

function checkImageIfExists($dir, $path)
{
    if (file_exists($dir . $path)) {
        return $dir . $path;
    } else {
        return $dir . $_SESSION['DEFAULT_IMAGE_PATH'];
    }
}

function uploadImage($image, $path)
{
    // Check if file was uploaded without errors
    if (isset($image) && $image["error"] == 0) {
        $FName = $image["name"]; // The name of the uploaded file
        $FTmp  = $image["tmp_name"]; // The temporary file path on the server

        // Move the uploaded file to the desired location
        $new_path = uniqid() . '_image.' . pathinfo($FName, PATHINFO_EXTENSION); // Generate a unique filename

        if (move_uploaded_file($FTmp, $path . $new_path)) {
            return $new_path;
        } else {
            return NULL;
        }
    }
}

function deleteImage($dir, $path)
{
    // Check if the file exists before attempting to delete it
    // If the file is not “default.png”, we proceed with the deletion
    if (file_exists($dir . $path) && $path != $_SESSION['DEFAULT_IMAGE_PATH']) {
        // Attempt to delete the file
        unlink($dir . $path);
    }
}

function flash($status, $message)
{
    $_SESSION['toastr'][] = [
        'status' => $status,
        'message' => $message
    ];
    return NULL;
}
function isAdmin($id)
{
    global $conn;
    if ($id) {
        $query = 'SELECT is_admin FROM users WHERE user_id = ?';
        $stmt = $conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetchColumn();
    } else {
        return false;
    }
}

function isAuthorized($id = NULL)
{
    if (isAdmin($id)) {
        return true;
    }
    if ($id) {
        if ((isset($_SESSION['USER']) && $_SESSION['USER']['user_id'] == $id)) {
            return true;
        } else {
            return false;
        }
    } else {
        if (isset($_SESSION['USER'])) {
            return true;
        } else {
            return false;
        }
    }
}

function diffHumans($date)
{
    // Given date and time
    $givenDateTime = new DateTime($date);

    // Current date and time
    $currentDateTime = new DateTime();

    // Calculate the difference
    $interval = $currentDateTime->diff($givenDateTime);

    // Format the difference
    $humanDiff = '';
    if ($interval->y > 0) {
        $humanDiff = $interval->y . ' year' . ($interval->y > 1 ? 's' : '') . ' ago';
    } elseif ($interval->m > 0) {
        $humanDiff = $interval->m . ' month' . ($interval->m > 1 ? 's' : '') . ' ago';
    } elseif ($interval->d > 0) {
        $humanDiff = $interval->d . ' day' . ($interval->d > 1 ? 's' : '') . ' ago';
    } elseif ($interval->h > 0) {
        $humanDiff = $interval->h . ' hour' . ($interval->h > 1 ? 's' : '') . ' ago';
    } elseif ($interval->i > 0) {
        $humanDiff = $interval->i . ' minute' . ($interval->i > 1 ? 's' : '') . ' ago';
    } elseif ($interval->s > 0) {
        $humanDiff = $interval->s . ' second' . ($interval->s > 1 ? 's' : '') . ' ago';
    } else {
        $humanDiff = 'just now';
    }
    return $humanDiff;
}


function getCities($city_selected = NULL)
{
    $jsonData = '{
        "Lebanon": {
          "cities": [
            "Beirut", "Tripoli","Sidon",
            "Tyre",
            "Byblos",
            "Jounieh",
            "Baalbek",
            "Nabatieh",
            "Zahle",
            "Batroun",
            "Zgharta",
            "Bsharri",
            "Aley",
            "Bint Jbeil",
            "Chouf",
            "Jezzine",
            "Marjayoun",
            "Rashaya",
            "Bekaa Valley",
            "Zahle",
            "Anjar"
          ]
        }
      }';

    $lebanonData = json_decode($jsonData);
    $cities = $lebanonData->Lebanon->cities;

    if ($cities) {
        foreach ($cities as $city) {
            echo "<option value='{$city}'" . (strtolower($city_selected) == strtolower($city) ? ' selected' : '') . ">{$city}</option>";
        }
    } else {
        echo "<option value='' disabled>No cities found</option>";
    }
}

function checkParams($arr)
{
    if (is_array($arr)) {
        foreach ($arr as $a) {
            echo isset($_GET[$a]) && $_GET[$a] != '' ?  "&$a=" . $_GET[$a] : "";
        }
    }
}

function setActive($paths)
{
    if (is_array($paths)) {
        foreach ($paths as $path) {
            if ($_SERVER['PHP_SELF'] == asset($path)) {
                return 'active';
            }
        }
    }
}

function setAdmin($admin)
{
    if ($admin) {
        return '<span class="badge badge-success" data-toggle="tooltip" data-title="Yes">
        <i class="fas fa-check"></i>
      </span>';
    } else {
        return '<span class="badge badge-danger" data-toggle="tooltip" data-title="No">
        <i class="fas fa-times"></i>
      </span>';
    }
}

function fetchPaginatedUsers($user_id)
{
    global $conn;
    // Sanitize and handle search input
    $search = isset($_GET['search']) ? strtolower($_GET['search']) : '';
    $rows_per_page = isset($_SESSION['PER_PAGE']) ? $_SESSION['PER_PAGE'] : 5;
    $query = "SELECT COUNT(*) as counter_user FROM users
        INNER JOIN blood_groups ON users.blood_group_id = blood_groups.group_id  
        INNER JOIN statuses ON users.status_id = statuses.status_id
        WHERE (users.email LIKE '%$search%' OR users.username LIKE '%$search%')
        AND users.user_id <> $user_id";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $counter = $stmt->fetchColumn();

    $pages = ceil($counter / $rows_per_page);
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($current_page - 1) * $rows_per_page;

    $users_query = "SELECT users.user_id, users.username, users.gender, users.status_id, users.is_admin, users.profile_pic, users.city,
        users.donated_at, blood_groups.*, statuses.* FROM users
        INNER JOIN blood_groups ON users.blood_group_id = blood_groups.group_id  
        INNER JOIN statuses ON users.status_id = statuses.status_id
        WHERE (users.email LIKE '%$search%' OR users.username LIKE '%$search%')
        AND users.user_id <> $user_id
        ORDER BY users.user_id DESC LIMIT ?, ?";

    $stmt = $conn->prepare($users_query);
    $stmt->execute([$start, $rows_per_page]);
    $users = $stmt->fetchAll();

    return [$users, $pages, $start, $counter, $current_page];
}

function fetchUserDiseases($id)
{
    global $conn;
    $ds_query = 'SELECT user_diseases.*, diseases.* FROM users
    INNER JOIN user_diseases ON users.user_id = user_diseases.user_id
    INNER JOIN diseases ON user_diseases.disease_id = diseases.disease_id
    WHERE users.user_id = ?';
    $stmt = $conn->prepare($ds_query);
    $stmt->execute([$id]);
    $diseases = $stmt->fetchAll();
    return $diseases;
}

function fetchDiseases()
{
    global $conn;

    $query = 'SELECT * FROM diseases';
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll();
}

function fetchBloodGroups()
{
    global $conn;
    $query = 'SELECT * FROM blood_groups';
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll();
}

function fetchUser($id)
{
    global $conn;
    $query = 'SELECT users.*, blood_groups.* FROM users
        INNER JOIN blood_groups ON users.blood_group_id = blood_groups.group_id     
     WHERE user_id = ?';
    $stmt = $conn->prepare($query);
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function fetchStatuses($statusTypes = [])
{
    global $conn;
    if (count($statusTypes) > 0) {
        $placeholders = rtrim(str_repeat('?, ', count($statusTypes)), ', ');
        $query = "SELECT * FROM statuses WHERE status_type IN ($placeholders)";
    } else {
        $query = "SELECT * FROM statuses";
    }
    $stmt = $conn->prepare($query);
    $stmt->execute($statusTypes);
    return $stmt->fetchAll();
}

function DeleteUserDiseases($user_id)
{
    global $conn;
    try {
        $deleteQuery = 'DELETE FROM user_diseases WHERE user_id = ?';
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->execute([$user_id]);
    } catch (Exception $e) {
        return false;
    }
}

function InsertUserDiseases($user_id, $diseases)
{
    global $conn;

    if (count($diseases) > 0) {
        foreach ($diseases as $disease_id) {
            if ($disease_id != '') {
                $query = 'INSERT INTO user_diseases (user_id, disease_id) VALUES (?, ?)';
                $stmt = $conn->prepare($query);
                $stmt->execute([$user_id, $disease_id]);
            }
        }
    }
}

function UpdateUser(array $data)
{
    global $conn;
    if (is_array($data)) {
        $query = 'UPDATE users SET
        username = ?, name = ?,
        email = ?, phone_number = ?,
        gender = ?, birthday = ?,
        profile_pic = ?, city = ?, status_id = ?,
        blood_group_id = ?, is_admin = ?
        WHERE user_id = ?';
        $stmt = $conn->prepare($query);
        $stmt->execute($data);
    }
}

function fetchPaginatedDonors_Recipients($type)
{
    global $conn;
    $search = isset($_GET['search']) ? strtolower($_GET['search']) : '';
    $rows_per_page = isset($_SESSION['PER_PAGE']) ? $_SESSION['PER_PAGE'] : 5;

    $query = "SELECT COUNT(DISTINCT users.user_id) AS counter_user FROM users
    INNER JOIN appointments ON users.user_id = appointments.user_id
    WHERE (users.email LIKE '%$search%' OR users.username LIKE '%$search%') 
    AND appointments.type = ?";

    $stmt = $conn->prepare($query);
    $stmt->execute([$type]);
    $counter = $stmt->fetchColumn();
    $pages = ceil($counter / $rows_per_page);
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($current_page - 1) * $rows_per_page;
    $query = "SELECT  users.user_id, users.*, blood_groups.*, statuses.* FROM users
    INNER JOIN blood_groups ON users.blood_group_id = blood_groups.group_id  
    INNER JOIN statuses ON users.status_id = statuses.status_id
    WHERE  (users.email LIKE '%$search%' OR users.username LIKE '%$search%') 
    AND (users.user_id IN (SELECT user_id FROM appointments WHERE type = ?))
    LIMIT ?, ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$type,  $start, $rows_per_page]);
    $donors = $stmt->fetchAll();

    return [$donors, $pages, $start, $counter, $current_page];
}

function fetchBloodProcesses()
{
    global $conn;
    $query = 'SELECT * FROM blood_processes';
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll();
}
function fetchBloodProcess($id)
{
    global $conn;
    $query = "SELECT process_name FROM blood_processes WHERE process_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id]);
    return $stmt->fetchColumn();
}

function fetchBloodGroup($id)
{
    global $conn;
    $query = "SELECT group_name FROM blood_groups WHERE group_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id]);
    return $stmt->fetchColumn();
}
function redirectBack()
{
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
function fetchPaginatedAppointments($statuses = ['pending'])
{
    global $conn;
    $statuses = isset($_GET['status']) && $_GET['status'] != '' ? [$_GET['status']] : $statuses;
    if (count($statuses) > 0) {
        $placeholders = rtrim(str_repeat('?, ', count($statuses)), ', ');
    }
    $type = isset($_GET['type']) ? $_GET['type'] : NULL;
    $last = isset($_GET['last']) ? $_GET['last'] : 90;
    $group = isset($_GET['group']) ? $_GET['group'] : NULL;
    $search = isset($_GET['search']) ? $_GET['search'] : NULL;

    $rows_per_page = isset($_SESSION['PER_PAGE']) ? $_SESSION['PER_PAGE'] : 5;

    $query = "SELECT COUNT(*) FROM users
    INNER JOIN appointments ON users.user_id = appointments.user_id
    INNER JOIN blood_groups ON users.blood_group_id = blood_groups.group_id  
    INNER JOIN blood_processes ON appointments.blood_process_id = blood_processes.process_id  
    INNER JOIN statuses ON appointments.status_id = statuses.status_id
    WHERE  (users.email LIKE '%$search%' OR users.username LIKE '%$search%') 
    AND blood_groups.group_id LIKE '%$group%'
    AND statuses.status_type IN ($placeholders)
    AND appointments.type LIKE '%$type%'
    AND DATE_SUB(NOW(), INTERVAL $last DAY) <= appointments.updated_at
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute($statuses);
    $counter = $stmt->fetchColumn();
    $pages = ceil($counter / $rows_per_page);
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($current_page - 1) * $rows_per_page;

    $data_query = "SELECT users.*, blood_groups.*, statuses.*, appointments.*, blood_processes.* FROM users
    INNER JOIN appointments ON users.user_id = appointments.user_id
    INNER JOIN blood_groups ON users.blood_group_id = blood_groups.group_id  
    INNER JOIN blood_processes ON appointments.blood_process_id = blood_processes.process_id  
    INNER JOIN statuses ON appointments.status_id = statuses.status_id
    WHERE  (users.email LIKE '%$search%' OR users.username LIKE '%$search%') 
    AND appointments.type LIKE '%$type%' 
    AND statuses.status_type IN ($placeholders)
    AND blood_groups.group_id LIKE '%$group%'
    AND DATE_SUB(NOW(), INTERVAL $last DAY) <= appointments.updated_at
    ORDER BY appointments.created_at DESC
    LIMIT $start, $rows_per_page";

    $stmt = $conn->prepare($data_query);
    $stmt->execute($statuses);
    $appointments = $stmt->fetchAll();

    return [$appointments, $pages, $start, $counter, $current_page];
}

function countBloodGroups(array $data)
{
    // Initialize counters for each blood group
    $groupCounts = array(
        "A+" => 0,
        "A-" => 0,
        "B+" => 0,
        "B-" => 0,
        "AB+" => 0,
        "AB-" => 0,
        "O+" => 0,
        "O-" => 0
    );

    // Count for each blood group
    foreach ($data as $d) {
        $groupName = $d['group_name'];
        if (isset($groupCounts[$groupName])) {
            $groupCounts[$groupName]++;
        }
    }
    return $groupCounts;
}

function fetchCountingHomeData()
{
    global $conn;
    $query = "SELECT appointments.user_id, appointments.appointment_id, users.*, appointments.type, statuses.* ,blood_groups.*
  FROM users
  INNER JOIN appointments ON users.user_id = appointments.user_id
  INNER JOIN blood_groups ON users.blood_group_id = blood_groups.group_id
  INNER JOIN statuses ON appointments.status_id = statuses.status_id
  ";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $data = $stmt->fetchAll();

    $waiting_list = array_filter($data, function ($arr) {
        return $arr['status_type'] == 'approved';
    });

    $requests = array_filter($data, function ($arr) {
        return $arr['status_type'] == 'pending';
    });

    $donations = array_filter($data, function ($arr) {
        return $arr['type'] == 'donation' && $arr['status_type'] == 'completed';
    });

    $requests_ = array_filter($data, function ($arr) {
        return $arr['type'] == 'request' && $arr['status_type'] == 'completed';
    });

    $donors = array_unique(array_map(function ($item) {
        return $item['user_id'];
    }, $donations));

    $recipients = array_unique(array_map(function ($item) {
        return $item['user_id'];
    }, $requests_));
    return [
        $donors, $recipients, $waiting_list, $requests
    ];
}

function fetchUserAppointments($statuses = ['pending', 'canceled', 'approved', 'rejected'])
{
    global $conn;

    // Default statuses if none provided via $_GET
    $statuses = isset($_GET['status']) && $_GET['status'] != '' ? [$_GET['status']] : $statuses;

    // Prepare placeholders for SQL query
    $placeholders = rtrim(str_repeat('?, ', count($statuses)), ', ');

    // User ID from session
    $user_id = $_SESSION['USER']['user_id'] ?? null;

    // Query with parameterized placeholders
    $data_query = "SELECT users.*, blood_groups.*, statuses.*, appointments.*, blood_processes.* FROM appointments
        INNER JOIN users ON appointments.user_id = users.user_id  
        INNER JOIN blood_processes ON appointments.blood_process_id = blood_processes.process_id  
        INNER JOIN blood_groups ON users.blood_group_id = blood_groups.group_id 
        INNER JOIN statuses ON appointments.status_id = statuses.status_id
        WHERE statuses.status_type IN ($placeholders)
        AND users.user_id = ?
        ORDER BY appointments.updated_at DESC 
        LIMIT 6";

    // Prepare and execute the statement
    $stmt = $conn->prepare($data_query);
    $stmt->execute(array_merge($statuses, [$user_id]));
    $appointments = $stmt->fetchAll();

    return $appointments;
}

function setStatusAppointment($status)
{
    switch ($status) {
        case 'pending':
            return "<span class='btn btn-warning text-white btn-sm text-sm'  style='font-size:9px'><i class='fas fa-clock'></i></span>";
            break;
        case 'approved':
            return "<span class='btn btn-info text-white btn-sm text-sm' style='font-size:9px'><i class='fas fa-check'></i></span>";
            break;
        case 'canceled':
            return "<span class='btn btn-warning text-white btn-sm text-sm' style='font-size:9px'><i class='fas fa-times'></i></span>";
            break;
        case 'rejected':
            return "<span class='btn btn-danger text-white btn-sm text-sm' style='font-size:9px'><i class='fas fa-times'></i></span>";
            break;
        case 'completed':
            return "<span class='btn btn-success text-white btn-sm text-sm '  style='font-size:9px'><i class='fas fa-check'></i></span>";
            break;
        default:
            return "<span class='btn btn-success text-white btn-sm text-sm' style='font-size:9px'><i class='fas fa-clock'></i></span>";
            break;
    }
}

function insertUser($data, $diseases = [])
{
    global $conn;
    // Insert user data into the database
    $query = 'INSERT INTO users (
        name, username, email, passwrd,
        phone_number, gender,
        city, birthday, blood_group_id 
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);';

    $stmt = $conn->prepare($query);
    $stmt->execute($data);

    $user_id = $conn->lastInsertId();

    // Insert diseases associated with the user
    InsertUserDiseases($user_id,  $diseases);
}
function validateUser($field, $value)
{
    if ($field == 'username' && strlen($value) < 3) {
        flash('error', 'Username must be at least 3 characters');
        return false;
    } elseif ($field == 'password' && strlen($value) < 6) {
        flash('error', 'Password must be at least 6 characters');
        return false;
    } else {
        return true;
    }
}
function checkDate2($databaseTimestamp)
{
    $difference = abs(time() - strtotime($databaseTimestamp));
    $days = floor($difference / (60 * 60 * 24));
    return $days;
}
function createNewAppointment($id, $bprocess, $type, $bunit, $case_details)
{
    global $conn;
    $query = "INSERT INTO appointments(user_id, blood_process_id, type, blood_unit, case_details) VALUES (?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id, $bprocess, $type, $bunit, $case_details]);
    return true;
}
function checkIfLimited($bprocess_id, $bunit)
{
    global $conn;
    $query = "SELECT min_, max_ FROM blood_processes WHERE process_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$bprocess_id]);
    $data = $stmt->fetch();
    $min = $data['min_'];
    $max = $data['max_'];

    if ($bunit >= $min && $bunit <= $max) {
        return [true, null];
    } else {
        return [false, $min, $max];
    }
}
function deleteAppointment($id)
{
    global $conn;
    $query = "DELETE FROM appointments WHERE appointment_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id]);
}
function deleteUser($user_id)
{
    global $conn;
    $delete_query = 'DELETE FROM users WHERE user_id = ?';
    $stmt = $conn->prepare($delete_query);
    $stmt->execute([$user_id]);
}


function canUserDonate($userId, $processId, $bunit)
{
    global $conn;

    $checked_ = checkIfLimited($processId, $bunit);
    if (!$checked_[0]) {
        if ($checked_[1] == $checked_[2]) {
            return [false, "Invalid unit! The required unit is {$checked_[1]} mL"];
        } else {
            return [false, "Invalid unit! The unit should be between {$checked_[1]} and {$checked_[2]} mL"];
        }
    }

    $query = "SELECT donated_at FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$userId]);
    $donated_at = $stmt->fetchColumn();
    $date_checked_donate = checkDate2($donated_at);

    // Check interval since last donation
    $query = "SELECT interval_days FROM blood_processes WHERE process_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$processId]);
    $intervalDays = $stmt->fetchColumn();

    if ($date_checked_donate < $intervalDays && $donated_at != null) {
        return [false, "You must wait " . ($intervalDays -  $date_checked_donate) . " more days until you can donate again."];
    }

    // Check if user has ongoing or pending donation appointments
    $query = "SELECT COUNT(*) FROM appointments
                INNER JOIN statuses ON appointments.status_id = statuses.status_id
                WHERE appointments.type = 'donation'
                AND appointments.user_id = ? 
                AND statuses.status_type IN ('approved', 'pending')";
    $stmt = $conn->prepare($query);
    $stmt->execute([$userId]);
    $appointment = $stmt->fetchColumn();

    if ($appointment > 0) {
        return [false, 'Unable to donate, you already have a donation appointment in progress.'];
    }

    return [true, null];
}
function canUserReceive($userId)
{
    global $conn;

    // Check if user has ongoing or pending request appointments
    $query = "SELECT COUNT(*) FROM appointments
                INNER JOIN statuses ON appointments.status_id = statuses.status_id
                WHERE appointments.type = 'request'
                AND appointments.user_id = ? 
                AND statuses.status_type IN ('approved', 'pending')";
    $stmt = $conn->prepare($query);
    $stmt->execute([$userId]);
    $appointment = $stmt->fetchColumn();

    if ($appointment > 0) {
        return [false, 'Unable to receive, you already have a request appointment in progress.'];
    }

    return [true, null];
}
