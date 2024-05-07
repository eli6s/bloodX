<?php
include '../../config.php';
include '../../helpers/helpers.php';
$pageTitle = "Supplicants";

ob_start();

// Start the session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

list($recipients, $pages, $start, $counter, $current_page) = fetchPaginatedDonors_Recipients('request');
$count = $start;
?>
<!-- Recipients -->
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="<?= '../'; ?>" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Recipients </h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="../">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="">Recipients</a></div>
            <div class="breadcrumb-item">Recipients Details</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12 ">
                <div class="card">
                    <div class="card-header">
                        <h4>Recipients Details</h4>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="py-3 align-middle px-2">#</th>
                                        <th class="py-3 px-4">Author</th>
                                        <th class="py-3">Diseases</th>
                                        <th class="py-3">Blood Group</th>
                                        <th class="py-3">City</th>
                                        <th class="py-3">Gender</th>
                                        <th class="py-3">Status</th>
                                        <th class="py-3">Admin</th>
                                        <th class="py-3">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if ($counter > 0) : ?>
                                        <?php foreach ($recipients as $user) : ?>
                                            <?php
                                            $count += 1;
                                            $diseases = fetchUserDiseases($user['user_id']);
                                            ?>

                                            <tr>
                                                <td class="align-middle px-2"><?= $count; ?></td>

                                                <td>
                                                    <a class="btn font-weight-bold " target="_blank" href="<?= asset('profile/index.php?id=' . $user['user_id']) ?>">
                                                        <img class="rounded-circle mx-1 bg-white" style="object-fit: cover;" src="<?= asset('assets/uploads/' . $user['profile_pic']) ?>" alt="" width="40" height="40">
                                                        <?= ucwords($user['username']); ?>
                                                    </a>
                                                </td>
                                                <td class="align-middle">
                                                    <?php if (count($diseases) > 0) : ?>
                                                        <div class="dropdown mr-2 dropbottom">
                                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ambulance"></i> </button>
                                                            <div class="dropdown-menu">
                                                                <?php foreach ($diseases as $disease) : ?>
                                                                    <a class="dropdown-item text-danger has-icon" href="#"><i class="fas fa-tint"></i><?= ucwords($disease['disease_name']); ?></a>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                    <?php else : ?>
                                                        <span class="badge badge-success"><i class="fas fa-thumbs-up "></i></span>
                                                    <?php endif; ?>
                                                </td>

                                                <td class="align-middle"><?= $user["group_name"]; ?></td>
                                                <td class="align-middle"><?= $user["city"]; ?></td>
                                                <td class="align-middle"><?= ucwords($user["gender"]); ?></td>
                                                <td class="align-middle"><?= setStatus($user["status_type"]); ?></td>
                                                <td class="align-middle"><?= setAdmin($user["is_admin"]); ?></td>
                                                <td class="align-middle">
                                                    <a class="btn btn-sm btn-action btn-info mr-1 " title="Edit" href="edit.php?id=<?= $user['user_id']; ?><?= isset($_GET['search']) && $_GET['search'] != '' ? '&search=' . $_GET['search'] : ''; ?>">
                                                        <i class="fa fa-pencil-alt"></i>
                                                    </a>
                                                    <a class="btn btn-danger btn-sm btn-action delete-item" title="Delete" href="delete.php" data-id="<?= $user['user_id']; ?>" data-image="<?= $user['profile_pic']; ?>"><i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>

                                    <?php else : ?>
                                        <tr>
                                            <td class="text-center font-weight-bold" colspan="10">No records found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <?php $counter > 0 ? include_once '../pagination.php' : ''; ?>
                </div>
            </div>
        </div>
</section>
<!-- Recipients end -->
<?php
$content = ob_get_clean();
include('../layout.php');
?>