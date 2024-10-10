<?php
session_start();
include '../../connection/connection.php';

// Query to get distinct school years
$query_school_years = "SELECT DISTINCT section.school_year FROM section ORDER BY section.school_year DESC";
$result_school_years = $conn->query($query_school_years);

$school_years = [];
while ($row = $result_school_years->fetch_assoc()) {
    $school_years[] = $row['school_year'];
}

$conn->close();
?>
<!DOCTYPE html>
<html data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light only">
    <title>Antonio C. Esguerra MNHS</title>
    <link rel="stylesheet" href='../../styles/tailwind.css'>
    <link rel="stylesheet" href='../../styles/style.css'>
    <link rel="icon" href="../../assets/acemnhs_logo.png">
</head>

<body>
    <div class="flex flex-row sm:gap-5">
        <div class="sm:w-full sm:max-w-[18rem]">
            <input type="checkbox" id="sidebar-mobile-fixed" class="sidebar-state" />
            <label for="sidebar-mobile-fixed" class="sidebar-overlay"></label>
            <aside
                class="sidebar sidebar-fixed-left sidebar-mobile h-full justify-start max-sm:fixed max-sm:-translate-x-full">
                <section class="sidebar-title items-center p-4 gap-2">
                    <img src="../../assets/acemnhs_logo.png" class="w-14" alt="">
                    <div class="flex flex-col">
                        <span class="text-lg">ACEMN High School</span>
                        <span class="text-xs font-normal text-content2">Grading System</span>
                    </div>
                </section>
                <section class="sidebar-content">
                    <nav class="menu rounded-md">
                        <section class="menu-section px-4">
                            <span class="menu-title">Welcome, <?php echo $_SESSION['username']; ?></span>
                            <ul class="menu-items">
                                <a href="departments.php">
                                    <li class="menu-item ">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-75" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span>Faculty</span>
                                    </li>
                                </a>
                                <a href="sections.php">
                                    <li class="menu-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-75" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <span>Students</span>
                                    </li>
                                </a>
                                <a href="reports.php">
                                    <li class="menu-item menu-active">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-75" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                        <span>Reports</span>
                                    </li>
                                </a>
                            </ul>
                        </section>

                    </nav>
                </section>
                <section class="sidebar-footer justify-end bg-gray-2 pt-2">
                    <div class="divider my-0"></div>
                    <div class="dropdown z-50 flex h-fit w-full cursor-pointer hover:bg-gray-4">
                        <label class="whites mx-2 flex h-fit w-full cursor-pointer p-0 hover:bg-gray-4" tabindex="0">
                            <div class="flex flex-row gap-4 p-4">
                                <div class="avatar-square avatar avatar-md">
                                    <img src="https://i.pravatar.cc/150?img=30" alt="avatar" />
                                </div>

                                <div class="flex flex-col">
                                    <span><?php echo $_SESSION['username']; ?></span>
                                    <span class="text-xs">Administrator</span>
                                </div>
                            </div>
                        </label>
                        <div class="dropdown-menu-right-top dropdown-menu ml-2">
                            <a href="settings.php" tabindex="-1" class="dropdown-item text-sm">Account settings</a>
                            <a href="../../connection/logout.php" tabindex="-1" class="dropdown-item text-sm">Logout</a>
                        </div>
                    </div>
                </section>
            </aside>
        </div>
        <main class="main-content flex-1 p-8 overflow-x-auto">
            <div class="w-fit">
                <label for="sidebar-mobile-fixed" class="btn-primary btn sm:hidden">Open Sidebar</label>
            </div>



            <div class="mx-auto w-full flex justify-center items-center gap-2 px-auto">
                <label for="school_year" class="font-bold">Select School Year:</label>
                <select id="school_year" class="select">
                    <?php foreach ($school_years as $year): ?>
                        <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>


            <div class="flex gap-2 pt-4">
                <div class="flex gap-4 flex-col items-center">
                    <h2 class="font-medium text-s">Student AKAP Status Report</h2>
                    <canvas id="akapStatusChart" width="900" height="500"></canvas>
                </div>
                <div class="font-medium flex gap-4 flex-col items-center">
                    <h2 class="text-s">Student Gender Distribution</h2>
                    <canvas id="genderChart" width="500" height="500"></canvas>
                </div>
            </div>
            <div class="w-full mt-8">
                <div class="flex gap-4 flex-col items-center">
                    <h2 class="font-medium text-s">Student AKAP Status Report</h2>
                    <canvas id="akapCasesChart" width="900" height="500"></canvas>
                </div>
            </div>

    </div>
    </main>
    </div>
</body>
<script src="../../../node_modules/chart.js/dist/chart.umd.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Function to update the charts dynamically based on the selected school year
    function updateCharts(schoolYear) {
        $.ajax({
            url: 'fetch_chart_data.php', // PHP script that fetches data for the selected school year
            type: 'GET',
            data: { school_year: schoolYear },
            success: function (response) {
                const data = JSON.parse(response);

                // Update the AKAP Status chart
                akapStatusChart.data.labels = ['AKAP Status'];
                akapStatusChart.data.datasets.forEach((dataset, index) => {
                    dataset.data = [data.akapStatusCounts[index] || 0];
                });
                akapStatusChart.update();

                // Update the Gender Distribution chart
                genderChart.data.labels = data.genderLabels.length ? data.genderLabels : ['Male', 'Female'];
                genderChart.data.datasets[0].data = data.genderCounts.length ? data.genderCounts : [0, 0];
                genderChart.update();

                // Update the AKAP Cases chart
                akapCasesChart.data.labels = data.akapCasesLabels;
                akapCasesChart.data.datasets[0].data = data.akapCasesCounts;
                akapCasesChart.update();
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error: ', error);
            }
        });
    }

    // Initialize Chart.js charts (empty for now)
    const ctx1 = document.getElementById('akapStatusChart').getContext('2d');
    const akapStatusChart = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: ['AKAP Status'],
            datasets: [{
                label: 'Inactive',
                data: [0],
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1
            }, {
                label: 'Active',
                data: [0],
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }, {
                label: 'Solved',
                data: [0],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        color: 'black',
                        font: {
                            size: 14
                        }
                    }
                }
            }
        }
    });

    const ctx2 = document.getElementById('genderChart').getContext('2d');
    const genderChart = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['Male', 'Female'],
            datasets: [{
                label: 'Gender Distribution',
                data: [0, 0],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)', // Blue for Male
                    'rgba(255, 99, 132, 0.2)' // Red for Female
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        color: 'black',
                        font: {
                            size: 14
                        }
                    }
                }
            }
        }
    });

    // Initialize the AKAP Cases chart
    const ctx3 = document.getElementById('akapCasesChart').getContext('2d');
    const akapCasesChart = new Chart(ctx3, {
        type: 'line',
        data: {
            labels: [], // School year labels
            datasets: [{
                label: 'AKAP Cases (Active and Solved)',
                data: [], // Data for AKAP cases across years
                backgroundColor: 'rgba(153, 102, 255, 0.2)', // Purple
                borderColor: 'rgba(153, 102, 255, 1)', // Purple border
                borderWidth: 2,
                fill: false
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        color: 'black',
                        font: {
                            size: 14
                        }
                    }
                }
            }
        }
    });

    // When the dropdown value changes, update the charts
    $('#school_year').change(function () {
        const selectedYear = $(this).val();
        updateCharts(selectedYear); // Update the charts for the selected school year
    });

    // Initially load charts for the first school year in the dropdown
    const initialYear = $('#school_year').val();
    updateCharts(initialYear);
</script>




</html>