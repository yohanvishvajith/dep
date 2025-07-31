<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container py-5">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold">Branch Dashboard</h1>
                <p class="text-muted mb-0">Manage your staff accounts</p>
            </div>
            <button class="btn btn-success d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#userModal">
                <i class="fas fa-user-plus me-2"></i> Add User
            </button>
        </div>

        <!-- Stat Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle me-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <p class="mb-1 text-muted">Total Staff</p>
                            <h4 class="mb-0" id="totalStaff">{{ $totalemployees }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 text-success p-3 rounded-circle me-3">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div>
                            <p class="mb-1 text-muted">Total services</p>
                            <h4 class="mb-0" id="activeToday">{{ $totalservices }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-circle me-3">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <p class="mb-1 text-muted">Total Counters</p>
                            <h4 class="mb-0" id="pendingRequests">{{ $totalcounters }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         <!-- Add Services Section -->
        <div class="card shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Branch Services</h5>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                    <i class="fas fa-plus me-1"></i> Add New Service
                </button>
            </div>
            <div class="table-responsive p-3">
                <table class="table table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                          
                            <th>Service Name</th>
                            
                         
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="servicesTableBody">
                        @foreach($services as $service)
                        <tr>
                            <td>{{ $service['name'] }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary me-2" title="Edit Service">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" title="Delete Service">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                       @endforeach
                       
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Assign Services -->
        <div class="card shadow-sm mb-5">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Assign Services to Counters</h5>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#serviceAssignModal">
                    <i class="fas fa-plus me-1"></i> Assign Service
                </button>
                   <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#counterAssignModal">
                    <i class="fas fa-plus me-1"></i> Assign Counters
                </button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#counterModal">
                    <i class="fas fa-plus me-1"></i> Add counter
                </button>
            </div>
            <div class="table-responsive p-3">
                <table class="table table-bordered mb-0">
    <thead class="table-light">
        <tr>
            <th>Counter</th>
            <th>In Charge</th>
            <th>Assigned Services</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="serviceAssignmentTableBody">
        @forelse ($serviceassign as $assign)
        <tr>
            <td>{{ $assign['counter'] }}</td>
            <td>{{ $assign['incharge'] }}</td>
            <td>
                @forelse ($assign['assigned_services'] as $service)
                    <span class="badge bg-primary me-1">{{ $service }}</span>
                @empty
                    <span class="text-muted">No services assigned</span>
                @endforelse
            </td>
            <td>
                <button class="btn btn-sm btn-outline-primary me-2">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-outline-danger">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center text-muted">No service assignments found.</td>
        </tr>
        @endforelse
    </tbody>
</table>

            </div>
        </div>

      

        <!-- Recent Staff Accounts Table -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Staff Accounts</h5>
                <button class="btn btn-link text-decoration-none text-primary">View All</button>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Counter ID</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                        @foreach($counterAssignments as $counterAssignment)
                    <tr>
                            <td>{{ $counterAssignment['counter_name']}}</td>
                            <td>{{ $counterAssignment['user_name']}}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary me-2"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-alt"></i></button>
                            </td>
                    </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- User Modal -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="modalCounterId" class="form-label">Counter ID</label>
                        <input type="text" class="form-control" id="modalCounterId" required>
                    </div>
                    <div class="mb-3">
                        <label for="modalFullName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="modalFullName" required>
                    </div>
                    <div class="mb-3">
                        <label for="modalUsername" class="form-label">Username</label>
                        <input type="text" class="form-control" id="modalUsername" required>
                    </div>
                    <div class="mb-3">
                        <label for="modalPassword" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="modalPassword" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePasswordBtn"><i class="fas fa-eye"></i></button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add User</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Assign Service Modal -->
    <div class="modal fade" id="serviceAssignModal" tabindex="-1" aria-labelledby="serviceAssignModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="post" action="/assignservice">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="serviceAssignModalLabel">Assign Services</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="selectCounter" class="form-label">Select Counter</label>
                        <select id="selectCounter" class="form-select" name="counter_id" required>
                            <option selected disabled>Choose a counter...</option>
                            @foreach($counters as $counter)
                              <option value="{{$counter->id}}">{{$counter->name}}</option>
                            @endforeach
                            <option>Counter 1 - John Doe</option>
                            <option>Counter 2 - Jane Smith</option>
                        </select>
                    </div>
                    <label class="form-label">Available Services</label>
                  @foreach($services as $service)
<div class="form-check">
    <input class="form-check-input" 
           type="checkbox" 
           value="{{ $service['id'] }}" 
           name="service_ids[]" 
           id="service_{{ $service['id'] }}">
    <label class="form-check-label" for="service_{{ $service['id'] }}">
        {{ $service['name'] }}
    </label>
</div>
@endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Assign Services</button>
                </div>
            </form>
        </div>
        
    </div>
 <!-- Add Service Modal -->
    <div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" class="modal-content" id="addServiceForm" action="{{route('addservice')}}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addServiceModalLabel">Add New Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="serviceName" class="form-label">Service Name</label>
                        <input type="text" class="form-control" id="serviceName" name="serviceName" placeholder="e.g., Money Transfer" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-success" value="Add Service">
                </div>
            </form>
        </div>
    </div>
    <!-- counter Modal -->
    <div class="modal fade" id="counterModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" class="modal-content" id="addServiceForm" action="{{route('addcounter')}}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addServiceModalLabel">Add New Counter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="serviceName" class="form-label">Counter Name</label>
                        <input type="text" class="form-control" id="serviceName" name="Name" placeholder="e.g., Money Transfer" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-success" value="Add Counter">
                </div>
            </form>
        </div>
    </div>

      <!-- counter assign Modal -->
    <div class="modal fade" id="counterAssignModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" class="modal-content" id="addServiceForm" action="{{route('addcounterassign')}}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addServiceModalLabel">Add New Counter Assign</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="serviceName" class="form-label">Choose Counter</label>
                        <select class="form-select" id="serviceName" name="counter_id" required>
                            @foreach($counters as $counter)
                                <option value="{{ $counter->id }}">{{ $counter->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="employeeName" class="form-label">Choose Employee</label>
                        <select class="form-select" id="employeeName" name="incharge" required>
                            @foreach($employees as $employee)
                                <option value="{{ $employee['id'] }}">{{ $employee['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-success" value="Assign Counter">
                </div>
            </form>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById("togglePasswordBtn").addEventListener("click", () => {
            const passwordInput = document.getElementById("modalPassword");
            const type = passwordInput.type === "password" ? "text" : "password";
            passwordInput.type = type;
            document.getElementById("togglePasswordBtn").innerHTML = type === "password" ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
        });
    </script>
</body>
</html>
