<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Company Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-light">
  <div class="container py-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h1 class="h3 fw-bold">Company Dashboard</h1>
        <p class="text-muted mb-0">Manage your company branches</p>
      </div>
      <button class="btn btn-success d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#branchModal">
        <i class="fas fa-plus me-2"></i> Add Branch
      </button>
    </div>

    <!-- Stat Cards -->
    <div class="row g-3 mb-4">
      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-body d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle me-3">
              <i class="fas fa-building"></i>
            </div>
            <div>
              <p class="mb-1 text-muted">Total Branches</p>
              <h4 class="mb-0" id="totalBranches">5</h4>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-body d-flex align-items-center">
            <div class="bg-success bg-opacity-10 text-success p-3 rounded-circle me-3">
              <i class="fas fa-map-marker-alt"></i>
            </div>
            <div>
              <p class="mb-1 text-muted">Active Locations</p>
              <h4 class="mb-0" id="activeLocations">4</h4>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-body d-flex align-items-center">
            <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-circle me-3">
              <i class="fas fa-tasks"></i>
            </div>
            <div>
              <p class="mb-1 text-muted">Pending Approvals</p>
              <h4 class="mb-0" id="pendingApprovals">1</h4>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Branches Table -->
    <div class="card mb-4 shadow-sm">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Branch List</h5>
        <button class="btn btn-link text-decoration-none text-primary">View All</button>
      </div>
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th>Branch ID</th>
              <th>Branch Name</th>
              <th>Location</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="branchTableBody">
            <tr>
              <td>BR001</td>
              <td>Colombo Central</td>
              <td>Colombo</td>
              <td>
                <button class="btn btn-sm btn-outline-primary me-2"><i class="fas fa-edit"></i></button>
                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-alt"></i></button>
              </td>
            </tr>
            <tr>
              <td>BR002</td>
              <td>Kandy Branch</td>
              <td>Kandy</td>
              <td>
                <button class="btn btn-sm btn-outline-primary me-2"><i class="fas fa-edit"></i></button>
                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-alt"></i></button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Branch Modal -->
    <div class="modal fade" id="branchModal" tabindex="-1" aria-labelledby="branchModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="branchModalLabel">Add New Branch</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="branchId" class="form-label">Branch ID</label>
              <input type="text" class="form-control" id="branchId" required />
            </div>
            <div class="mb-3">
              <label for="branchName" class="form-label">Branch Name</label>
              <input type="text" class="form-control" id="branchName" required />
            </div>
            <div class="mb-3">
              <label for="branchLocation" class="form-label">Location</label>
              <input type="text" class="form-control" id="branchLocation" required />
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Add Branch</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
