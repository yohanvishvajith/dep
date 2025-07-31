<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Queue Display - kandy</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }
        
        .header {
            background: rgba(255, 255, 255, 0.95);
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .header h1 {
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .branch-info {
            color: #7f8c8d;
            font-size: 18px;
        }

        .branch-selector {
            margin: 10px 0;
        }

        .branch-selector select {
            padding: 8px 15px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            background: white;
        }
        
        .main-content {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
            padding: 20px;
            max-width: 1600px;
            margin: 0 auto;
            height: calc(100vh - 140px);
        }
        
        .column {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
        }
        
        .column h2 {
            color: #2c3e50;
            margin-bottom: 25px;
            text-align: center;
            font-size: 1.8rem;
            border-bottom: 3px solid #3498db;
            padding-bottom: 10px;
        }
        
        .current-serving {
            background: white;
        }
        
        .serving-grid {
            display: flex;
            flex-direction: column;
            gap: 15px;
            flex: 1;
            overflow-y: auto;
        }
        
        .serving-ticket {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            animation: pulse 2s infinite;
            min-height: 120px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }
        
        .serving-ticket .token {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 8px;
        }
        
        .serving-ticket .counter {
            background: rgba(255,255,255,0.2);
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 1rem;
            margin-bottom: 8px;
            display: inline-block;
        }
        
        .serving-ticket .service {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .waiting-queue {
            background: white;
        }
        
        .queue-list {
            flex: 1;
            overflow-y: auto;
        }
        
        .queue-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #ecf0f1;
            transition: background 0.3s;
        }
        
        .queue-item:hover {
            background: #f8f9fa;
        }
        
        .queue-item:last-child {
            border-bottom: none;
        }
        
        .queue-token {
            font-size: 1.3rem;
            font-weight: bold;
            color: #3498db;
        }
        
        .queue-service {
            color: #7f8c8d;
            font-size: 0.85rem;
            margin-top: 2px;
        }

        .queue-customer {
            color: #95a5a6;
            font-size: 0.8rem;
            margin-top: 2px;
        }
        
        .queue-position {
            background: #3498db;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: bold;
        }
        
        .counters-status {
            background: white;
        }
        
        .counter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 15px;
            flex: 1;
            overflow-y: auto;
        }
        
        .counter-status {
            text-align: center;
            padding: 15px 10px;
            border-radius: 8px;
            font-weight: bold;
            height: fit-content;
        }
        
        .counter-status.open {
            background: #2ecc71;
            color: white;
        }
        
        .counter-status.closed {
            background: #e74c3c;
            color: white;
        }
        
        .counter-number {
            font-size: 1.1rem;
            margin-bottom: 5px;
        }
        
        .counter-user {
            font-size: 0.75rem;
            opacity: 0.9;
        }
        
        .last-updated {
            text-align: center;
            color: #7f8c8d;
            margin-top: 15px;
            font-style: italic;
            position: fixed;
            bottom: 10px;
            width: 100%;
        }

        .no-tickets {
            text-align: center;
            color: #7f8c8d;
            padding: 40px;
            font-size: 1.1rem;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-links {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .nav-links a {
            background: rgba(255,255,255,0.9);
            color: #2c3e50;
            padding: 8px 16px;
            border-radius: 20px;
            text-decoration: none;
            margin-left: 10px;
            transition: background 0.3s;
        }

        .nav-links a:hover {
            background: white;
        }
        
        @media (max-width: 1200px) {
            .main-content {
                grid-template-columns: 1fr;
                gap: 15px;
                height: auto;
            }
            
            .column {
                margin-bottom: 20px;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 10px;
            }
            
            .serving-ticket .token {
                font-size: 2rem;
            }
            
            .counter-grid {
                grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            }
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Queue Display</h1>
        <div class="branch-info">NetBees-Kandy</div>
    </div>
    
    <div class="main-content">
        <!-- Now Serving Column -->
        <div class="column current-serving">
            <h2>Now Serving</h2>
            <div class="serving-grid" id="currentTickets">
                @forelse($servingTickets as $ticket)
                    <div class="serving-ticket">
                        <div class="token">{{ $ticket['ticket_id'] }}</div>
                        <div class="counter">{{ $ticket['counter_name'] }}</div>
                    </div>
                @empty
                    <div class="no-tickets">No tickets currently being served</div>
                @endforelse
            </div>
        </div>
        
        <!-- Waiting Queue Column -->
        <div class="column waiting-queue">
            <h2>Waiting Queue</h2>
            <div class="queue-list" id="waitingQueue">
                @forelse($waitingTickets as $ticket)
                    <div class="queue-item">
                        <div>
                            <div class="queue-token">{{ $ticket->id }}</div>
                            <div class="queue-service">{{ $ticket->service->name }}</div>
                            <div class="queue-customer">{{ $ticket->customer_name ?? 'Guest' }}</div>
                        </div>
                    </div>
                @empty
                    <div class="no-tickets">No tickets in queue</div>
                @endforelse
            </div>
        </div>
        
        <!-- Counter Status Column -->
        <div class="column counters-status">
            <h2>Counter Status</h2>
            <div class="counter-grid" id="counterStatus">
                @foreach($counters as $counter)
                    <div class="counter-status open">
                        <div class="counter-number">{{ $counter['counter_name'] }}</div>
                        <div class="counter-user">{{ $counter['user_name'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <div class="last-updated" id="lastUpdated">
        Last updated: {{ now()->format('H:i:s') }}
    </div>

    <script>
        let branchId = '1';
        
        // Auto-refresh every 5 seconds
        setInterval(refreshData, 5000);
        
        function refreshData() {
            fetch(`/queue/${branchId}/data`)
                .then(response => response.json())
                .then(data => {
                    updateCurrentTickets(data.current_tickets);
                    updateWaitingQueue(data.waiting_tickets);
                    updateCounterStatus(data.counters);
                    updateLastUpdated(data.last_updated);
                })
                .catch(error => {
                    console.error('Error refreshing data:', error);
                });
        }
        
        function updateCurrentTickets(tickets) {
            const container = document.getElementById('currentTickets');
            
            if (tickets.length === 0) {
                container.innerHTML = '<div class="no-tickets">No tickets currently being served</div>';
                return;
            }
            
            container.innerHTML = tickets.map(ticket => `
                <div class="serving-ticket">
                    <div class="token">${ticket.token_number}</div>
                    <div class="counter">Counter ${ticket.counter.number}</div>
                    <div class="service">${ticket.service.name}</div>
                </div>
            `).join('');
        }
        
        function updateWaitingQueue(tickets) {
            const container = document.getElementById('waitingQueue');
            
            if (tickets.length === 0) {
                container.innerHTML = '<div class="no-tickets">No tickets in queue</div>';
                return;
            }
            
            container.innerHTML = tickets.map(ticket => `
                <div class="queue-item">
                    <div>
                        <div class="queue-token">${ticket.token_number}</div>
                        <div class="queue-service">${ticket.service.name}</div>
                    </div>
                    <div class="queue-position">${ticket.queue_position}</div>
                </div>
            `).join('');
        }
        
        function updateCounterStatus(counters) {
            const container = document.getElementById('counterStatus');
            
            container.innerHTML = counters.map(counter => `
                <div class="counter-status ${counter.is_open ? 'open' : 'closed'}">
                    <div class="counter-number">${counter.number}</div>
                    <div class="counter-user">
                        ${counter.is_open ? (counter.current_user ? counter.current_user.name : 'Open') : 'Closed'}
                    </div>
                </div>
            `).join('');
        }
        
        function updateLastUpdated(time) {
            document.getElementById('lastUpdated').textContent = `Last updated: ${time}`;
        }
    </script>
</body>
</html>
