<?php
include '../../config.php';
include '../../helpers/helpers.php';
$pageTitle = "Donations";

// Start the session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

ob_start();

list($appointments, $pages, $start, $counter, $current_page) =  fetchPaginatedAppointments();
$count = $start;

?>

<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="<?= '../'; ?>" title="Back" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Requests </h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="../">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="../">Requests</a></div>
            <div class="breadcrumb-item">Requests Details</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12 ">
                <div class="card">
                    <div class="card-header  d-flex justify-content-between align-items-center">
                        <h4>Request Details</h4>
                        <div class="dropdown w-25">
                            <button class="btn btn-primary dropdown-toggle w-100" type="button" id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= (isset($_GET['filter_by']) and $_GET['filter_by'] != '') ? ucwords($_GET['filter_by']) : 'Filter by' ?>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="filterDropdown">
                                <a class="dropdown-item" href="?filter_by=">Filter by</a>
                                <a class="dropdown-item" href="?filter_by=type">Type</a>
                                <a class="dropdown-item" href="?filter_by=group">Group</a>
                            </div>
                        </div>
                        <div class="dropdown w-25">
                            <button class="btn btn-primary dropdown-toggle w-100" type="button" id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= (isset($_GET['type']) && $_GET['type'] != '')
                                    ? ucwords($_GET['type'])  : (isset($_GET['group']) && $_GET['group'] != '' ? fetchBloodGroup($_GET['group']) : 'All') ?>
                            </button>
                            <?php if (isset($_GET['filter_by']) && $_GET['filter_by'] == 'type') : ?>
                                <div class="dropdown-menu" aria-labelledby="filterDropdown">
                                    <a class="dropdown-item" href="?type=">All</a>
                                    <a class="dropdown-item" href="?type=donation<?= checkParams(['filter_by']) ?>">Donations</a>
                                    <a class="dropdown-item" href="?type=request<?= checkParams(['filter_by']) ?>">Requests </a>
                                </div>
                            <?php elseif (isset($_GET['filter_by']) && $_GET['filter_by'] == 'group') : ?>
                                <div class="dropdown-menu" aria-labelledby="filterDropdown">
                                    <a class="dropdown-item" href="?group=<?= checkParams(['type']) ?>">All</a>
                                    <?php foreach (fetchBloodGroups() as $group) : ?>
                                        <a class="dropdown-item" href="?group=<?= $group['group_id'] ?><?= checkParams(['filter_by']) ?>"><?= $group['group_name'] ?></a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>

                    <div class="card-body ">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped " id="table-1">
                                <thead>
                                    <tr>
                                        <th class="align-middle py-3 px-2">#</th>
                                        <th class="py-3 px-4">Author</th>
                                        <th class="py-3">Diseases</th>
                                        <th class="py-3">Blood Group</th>
                                        <th class="py-3">Blood Process</th>
                                        <th class="py-3">Case Details </th>
                                        <th class="py-3">Unit (ML)</th>
                                        <th class="py-3">Requested </th>
                                        <th class="py-3">City</th>
                                        <th class="py-3">Type</th>
                                        <th class="py-3">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if ($counter > 0) : ?>
                                        <?php foreach ($appointments as $appointment) : ?>
                                            <?php
                                            $count += 1;
                                            $diseases = fetchUserDiseases($appointment['user_id']);
                                            ?>

                                            <tr>
                                                <td class="align-middle px-2"><?= $count; ?></td>

                                                <td>
                                                    <a class="btn font-weight-bold " target="_blank" href="<?= asset('profile/index.php?id=' . $appointment['user_id']) ?>">
                                                        <img class="rounded-circle mx-1 bg-white" style="object-fit: cover;" src="<?= asset('assets/uploads/' . $appointment['profile_pic']) ?>" alt="" width="40" height="40">
                                                        <?= ucwords($appointment['username']); ?>
                                                    </a>
                                                </td>
                                                <td class="align-middle">
                                                    <?php if (count($diseases) > 0) : ?>
                                                        <div class="dropdown mr-2 dropbottom">
                                                            <button class="btn btn-sm p-0 px-1 btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ambulance "></i> </button>
                                                            <div class="dropdown-menu ">
                                                                <?php foreach ($diseases as $disease) : ?>
                                                                    <a class="dropdown-item text-danger has-icon" href="#"><i class="fas fa-tint"></i><?= ucwords($disease['disease_name']); ?></a>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                    <?php else : ?>
                                                        <span class="badge badge-success"><i class="fas fa-thumbs-up "></i></span>
                                                    <?php endif; ?>
                                                </td>

                                                <td class="align-middle"><?= ucwords($appointment["group_name"]); ?></td>
                                                <td class="align-middle"><?= ucwords($appointment["process_name"]); ?></td>
                                                <td class="align-middle"><?= $appointment["case_details"] != '' ? $appointment['case_details'] : 'N/A'; ?></td>
                                                <td class="align-middle"><?= $appointment["blood_unit"]; ?></td>
                                                <td class="align-middle"><?= diffHumans($appointment["created_at"]) ?></td>
                                                <td class="align-middle"><?= ucwords($appointment["city"]) ?></td>
                                                <td class="align-middle"><?= ucwords($appointment["type"]); ?></td>
                                                <td class="align-middle">
                                                    <?= setStatus('pending', $appointment['appointment_id'], $appointment['user_id']) ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr class="">
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
<script>
    function openIt() {
        $("#modalApp").modal('show');
    }
</script>
<?php
$content = ob_get_clean();
include('../layout.php');
