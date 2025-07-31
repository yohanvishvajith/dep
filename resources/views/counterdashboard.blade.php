<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Counter Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Counter Dashboard - Tickets</h2>
        
        @if($tickets->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Ticket Number</th>
                            <th>Service</th>
                            <th>Status</th>
                            <th>Issue Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->id ?? 'N/A' }}</td>
                                <td>{{ $ticket->service->name ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-{{ $ticket->status == 'completed' ? 'success' : ($ticket->status == 'pending' ? 'warning' : ($ticket->status == 'serving' ? 'primary' : 'info')) }}">
                                        {{ ucfirst($ticket->status ?? 'N/A') }}
                                    </span>
                                </td>
                                <td>{{ $ticket->created_at->format('Y-m-d H:i:s') }}</td>
                                <td>
                                    @if($ticket->status == 'serving')
                                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#finishModal" data-ticket-id="{{ $ticket->id }}">
                                            Finish
                                        </button>
                                    @elseif($ticket->status != 'completed')
                                        <a href="{{ route('assign', $ticket->id) }}" class="btn btn-primary btn-sm">
                                            Assign
                                        </a>
                                    @else
                                        <span class="badge bg-success">Completed</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">
                <h4>No tickets found</h4>
                <p>There are no tickets assigned to counters</p>
            </div>
        @endif
    </div>

    <!-- Finish Modal -->
    <div class="modal fade" id="finishModal" tabindex="-1" aria-labelledby="finishModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="finishModalLabel">Finish Ticket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="finishForm" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="">Select Status</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Handle finish modal
        const finishModal = document.getElementById('finishModal');
        finishModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const ticketId = button.getAttribute('data-ticket-id');
            const form = document.getElementById('finishForm');
            form.action = `/finish/${ticketId}`;
        });
    </script>
</body>
</html>