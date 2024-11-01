<?php

use app\models\User;

/** @var yii\web\View $this */
/** @var app\models\TableTab[] $tableTabs */
/** @var app\models\Tab[] $tabs */

$this->title = 'Manage Tabs';

?>
<!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->

<div class="content-body">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex my-2">

                <div class="btn-group-ellipsis ms-auto">
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa-solid fa-ellipsis"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item fw-medium text-light-emphasis" href="#" data-bs-toggle="modal"
                                data-bs-target="#hideModal"><i class="fas fa-eye me-1"></i> Show/Hidden Tab</a></li>
                        <li><a class="dropdown-item fw-medium text-light-emphasis" href="#" data-bs-toggle="modal"
                                data-bs-target="#sortModal"><i class="fas fa-sort-amount-down me-1"></i> Sort Order
                                Tab</a>
                        </li>
                        <li><a class="dropdown-item fw-medium text-light-emphasis" href="#" data-bs-toggle="modal"
                                data-bs-target="#deleteModal"><i class="fas fa-trash-alt me-1"></i> Delete Tab</a>
                        </li>
                        <li><a class="dropdown-item fw-medium text-light-emphasis" href="#" data-bs-toggle="modal"
                                data-bs-target="#trashBinModal"> <i class="fas fa-trash me-1"></i> Trash Bin</a>
                        </li>
                    </ul>
                </div>
                <div class="settings ms-2">
                    <a class="btn btn-secondary" href="<?= \yii\helpers\Url::to(['tabs/settings']) ?>"
                        style="color: white; text-decoration: none;">
                        <i class="fa-solid fa-gear"></i>
                    </a>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs" id="tab-list">
                        <?php if (!empty($tabs)): ?>
                        <?php foreach ($tabs as $index => $tab): ?>
                        <?php if ($tab->deleted == 0): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $index === 0 ? 'active' : '' ?>" href="#" data-id="<?= $tab->id ?>">
                                <?= htmlspecialchars($tab->tab_name) ?>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <div class="align-items-center m-2">
                            <a class="btn btn-primary" href="<?= \yii\helpers\Url::to(['tabs/settings']) ?>">
                                Click here to add a new tab.
                            </a>
                        </div>
                        <?php endif; ?>
                    </ul>

                </div>
                <div class="card-body pt-0">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab-data-current">
                            <div class="table-responsive" id="table-data-current">
                                <!-- Dữ liệu sẽ được tải vào đây -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Trash Bin -->
<div class="modal fade" id="trashBinModal" tabindex="-1" aria-labelledby="trashBinModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="trashBinModalLabel">Trash Bin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Select the tab you want to restore or delete completely:</p>
                <table class="table table-bordered table-hover table-ui">
                    <thead>
                        <tr>
                            <th>Tab name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="trash-bin-list">
                        <?php $hasDeletedTabs = false; ?>
                        <?php foreach ($tabs as $tab): ?>
                        <?php if ($tab->deleted == 1): ?>
                        <?php $hasDeletedTabs = true; ?>
                        <tr>
                            <td><?= htmlspecialchars($tab->tab_name) ?></td>
                            <td>
                                <button type="button" class="btn btn-warning restore-tab-btn" id="confirm-restore-btn"
                                    data-tab-id="<?= htmlspecialchars($tab->id) ?>">
                                    <i class="fa-solid fa-rotate-left"></i>
                                </button>
                                <button type="button" class="btn btn-danger delete-tab-btn" id="delete-permanently-btn"
                                    data-tab-name="<?= htmlspecialchars($tab->tab_name) ?>"
                                    data-tab-id="<?= htmlspecialchars($tab->id) ?>">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php endforeach; ?>
                        <?php if (!$hasDeletedTabs): ?>
                        <tr>
                            <td colspan="2" class="text-center text-muted">
                                <em>There is nothing here.</em>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hide tab -->
<div class="modal fade" id="hideModal" tabindex="-1" aria-labelledby="hideModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hideModalLabel">Show/Hidden Tab</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body">
                <p>Select the tab you want to hide or show:</p>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tab name</th>
                            <th><i class="fa-solid fa-eye-slash"></i></th>
                        </tr>
                    </thead>
                    <tbody id="hide-tabs-list">
                        <?php foreach ($tabs as $tab): ?>
                        <?php if ($tab->deleted == 0 || $tab->deleted == 3): ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars($tab->tab_name) ?>
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input toggle-hide-btn" type="checkbox"
                                        data-tab-id="<?= htmlspecialchars($tab->id) ?>"
                                        <?php if ($tab->deleted == 3): ?> checked <?php endif; ?>>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirm-hide-btn">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Sort tab -->
<div class="modal fade" id="sortModal" tabindex="-1" aria-labelledby="sortModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sortModalLabel">Sort Tabs</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body">
                <p>Kéo và thả để sắp xếp các tab.</p>
                <ul class="list-group" id="sortable-tabs">
                    <?php foreach ($tabs as $index => $tab): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center"
                        data-tab-id="<?= $tab->id ?>">
                        <span><?= htmlspecialchars($tab->tab_name) ?></span>
                        <span class="badge bg-secondary"><?= $index + 1 ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirm-sort-btn">Save</button>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    $('#confirm-hide-btn').click(function() {
        let hideStatus = {};

        $('.toggle-hide-btn').each(function() {
            const tabId = $(this).data('tab-id');
            const isChecked = $(this).is(':checked');
            hideStatus[tabId] = isChecked ? 3 : 0;
        });

        $.ajax({
            url: '<?= \yii\helpers\Url::to(['tabs/update-hide-status']) ?>',
            method: 'POST',
            data: {
                hideStatus: hideStatus
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert(response.message || "An error occurred while saving changes.");
                }
            },
            error: function() {
                alert("An error occurred while saving changes.");
            }
        });
    });
    $("#sortable-tabs").sortable();

    $("#confirm-sort-btn").click(function() {
        var sortedData = [];
        $("#sortable-tabs li").each(function(index) {
            var tabId = $(this).data("tab-id");
            sortedData.push({
                id: tabId,
                position: index + 1
            });
        });

        $.ajax({
            url: '/tabs/update-sort-order',
            method: 'POST',
            data: {
                tabs: sortedData
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                    $('#sortModal').modal('hide');
                } else {
                    alert(response.message || "Error.");
                }
            },
            error: function() {
                alert("Error.");
            }
        });
    });
    $(document).on('click', '#confirm-restore-btn', function() {
        const tabId = $(this).data('tab-id');

        $.ajax({
            url: '<?= \yii\helpers\Url::to(['tabs/restore-tab']) ?>',
            method: 'POST',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                tabId: tabId,
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                    $('#trashBinModal').modal('hide');
                } else {
                    alert(response.message || "Restore table failed.");
                }
            },
            error: function(error) {
                alert("An error occurred while Restore table.");
            }
        });
    });
    $(document).ready(function() {
        $(document).on('click', '#delete-permanently-btn', function() {
            const tabId = $(this).data('tab-id');
            const tableName = $(this).data('tab-name');

            if (confirm("Are you sure you want to permanently delete this tab?")) {
                $.ajax({
                    url: '<?= \yii\helpers\Url::to(['tabs/delete-permanently-tab']) ?>',
                    method: 'POST',
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        tabId: tabId,
                        tableName: tableName,
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert(response.message || "Deletion failed.");
                        }
                    },
                    error: function(error) {
                        alert("An error occurred while deleting the tab.");
                    }
                });
            }
        });
    });

});
</script>

<script>
$(document).ready(function() {
    var firstTabId = <?= $tabs[0]->id ?>;
    loadTabData(firstTabId, $('.nav-link.active'));

    $('#tab-list').on('click', '.nav-link', function(e) {
        e.preventDefault();
        var tabId = $(this).data('id');

        $('.nav-link').removeClass('active');
        $(this).addClass('active');

        loadTabData(tabId, $(this));
    });
});

function loadTabData(tabId, element) {
    $.ajax({
        url: "<?= \yii\helpers\Url::to(['tabs/load-tab-data']) ?>",
        type: "GET",
        data: {
            tabId: tabId,
        },
        success: function(data) {
            $('#table-data-current').html(data);
            $('.tab-pane').removeClass('show active');
            $('#tab-data-current').addClass('show active');
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            alert('An error occurred while loading data. Please try again later.');
        }
    });
}
</script>