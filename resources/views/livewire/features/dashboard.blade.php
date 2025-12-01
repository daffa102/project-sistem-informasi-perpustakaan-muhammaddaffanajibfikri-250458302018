<div wire:poll.60s>
    <div class="page-content">
        <section class="row">
            <div class="col-12">

                {{-- STATS CARDS --}}
                <div class="row gy-4 mb-4">
                    <div class="col-6 col-lg-3">
                        <div class="card shadow-lg border-0" style="border-radius: 18px; background: linear-gradient(135deg, #7c3aed, #a855f7); color:white;">
                            <div class="card-body p-4">
                                <h6 class="text-white fw-light mb-1">Total Buku</h6>
                                <h2 class="fw-bold mb-0">{{ $booksCount }}</h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-lg-3">
                        <div class="card shadow-lg border-0" style="border-radius: 18px; background: linear-gradient(135deg, #2563eb, #60a5fa); color:white;">
                            <div class="card-body p-4">
                                <h6 class="text-white fw-light mb-1">Total Member</h6>
                                <h2 class="fw-bold mb-0">{{ $membersCount }}</h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-lg-3">
                        <div class="card shadow-lg border-0" style="border-radius: 18px; background: linear-gradient(135deg, #16a34a, #4ade80); color:white;">
                            <div class="card-body p-4">
                                <h6 class="text-white fw-light mb-1">Total Kategori</h6>
                                <h2 class="fw-bold mb-0">{{ $categoriesCount }}</h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-lg-3">
                        <div class="card shadow-lg border-0" style="border-radius: 18px; background: linear-gradient(135deg, #dc2626, #f87171); color:white;">
                            <div class="card-body p-4">
                                <h6 class="text-white fw-light mb-1">Total Peminjaman</h6>
                                <h2 class="fw-bold mb-0">{{ $borrowingsCount }}</h2>
                            </div>
                        </div>
                    </div>

                    {{-- CARD BUKU TERLAMBAT --}}
                    <div class="col-6 col-lg-3">
                        <div class="card shadow-lg border-0" style="border-radius: 18px; background: linear-gradient(135deg, #f59e0b, #fbbf24); color:white;">
                            <div class="card-body p-4">
                                <h6 class="text-white fw-light mb-1">Buku Terlambat</h6>
                                <h2 class="fw-bold mb-0">{{ $overdueBorrowings }}</h2>
                                <small class="text-white opacity-75">Perlu ditindaklanjuti</small>
                            </div>
                        </div>
                    </div>

                    {{-- CARD JATUH TEMPO DALAM 3 HARI --}}
                    <div class="col-6 col-lg-3">
                        <div class="card shadow-lg border-0" style="border-radius: 18px; background: linear-gradient(135deg, #8b5cf6, #a78bfa); color:white;">
                            <div class="card-body p-4">
                                <h6 class="text-white fw-light mb-1">Jatuh Tempo 3 Hari</h6>
                                <h2 class="fw-bold mb-0">{{ $dueSoonBorrowings }}</h2>
                                <small class="text-white opacity-75">Segera jatuh tempo</small>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CHARTS ROW --}}
                <div class="row gy-4 mb-4">
                    {{-- CHART BUKU PER KATEGORI --}}
                    <div class="col-12 col-lg-6">
                        <div class="card shadow-lg border-0" style="border-radius: 18px;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="fw-bold mb-0">
                                        <i class="bi bi-book text-purple me-2"></i>
                                        Distribusi Buku per Kategori
                                    </h5>
                                </div>
                                <div wire:ignore>
                                    <div id="categoryChart"
                                         style="height: 350px;"
                                         data-categories="{{ json_encode($chartCategories) }}"
                                         data-values="{{ json_encode($chartData) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- CHART MEMBER 7 HARI TERAKHIR --}}
                    <div class="col-12 col-lg-6">
                        <div class="card shadow-lg border-0" style="border-radius: 18px;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="fw-bold mb-0">
                                        <i class="bi bi-people text-primary me-2"></i>
                                        Pendaftaran Member (7 Hari Terakhir)
                                    </h5>
                                </div>
                                <div wire:ignore>
                                    <div id="memberChart"
                                         style="height: 350px;"
                                         data-dates="{{ json_encode($memberChartDates) }}"
                                         data-counts="{{ json_encode($memberChartCounts) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TOP 5 BUKU TERPOPULER --}}
                <div class="row gy-4">
                    <div class="col-12">
                        <div class="card shadow-lg border-0" style="border-radius: 18px;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="fw-bold mb-0">
                                        <i class="bi bi-trophy text-warning me-2"></i>
                                        Top 5 Buku Terpopuler
                                    </h5>
                                    <span class="badge bg-warning text-dark">Paling Sering Dipinjam</span>
                                </div>

                                @if($topBooks && $topBooks->count() > 0)
                                    <div class="list-group list-group-flush">
                                        @foreach($topBooks as $index => $book)
                                        <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-3 py-3">
                                            <div class="d-flex align-items-center gap-3 flex-grow-1">
                                                <div class="badge rounded-circle d-flex align-items-center justify-content-center"
                                                     style="width: 45px; height: 45px; font-size: 18px; font-weight: bold;
                                                            background: {{ $index === 0 ? 'linear-gradient(135deg, #f59e0b, #fbbf24)' :
                                                                          ($index === 1 ? 'linear-gradient(135deg, #94a3b8, #cbd5e1)' :
                                                                          ($index === 2 ? 'linear-gradient(135deg, #fb923c, #fdba74)' :
                                                                          'linear-gradient(135deg, #7c3aed, #a855f7)')) }}; color: white;">
                                                    {{ $index + 1 }}
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 fw-bold">{{ $book->title }}</h6>
                                                    <div class="d-flex gap-3 text-muted small">
                                                        <span><i class="bi bi-person me-1"></i>{{ $book->author }}</span>
                                                        <span><i class="bi bi-tag me-1"></i>{{ $book->category->name ?? 'Tanpa Kategori' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge bg-success rounded-pill px-3 py-2" style="font-size: 14px;">
                                                    <i class="bi bi-graph-up me-1"></i>{{ $book->borrowings_count }} peminjaman
                                                </span>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                        <p class="mb-0">Belum ada data peminjaman buku</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.49.1"></script>

<script>
(function() {
    let categoryChart = null;
    let memberChart = null;

    function getChartData() {
        const categoryEl = document.querySelector('#categoryChart');
        const memberEl = document.querySelector('#memberChart');

        if (!categoryEl || !memberEl) return null;

        return {
            categories: JSON.parse(categoryEl.getAttribute('data-categories') || '[]'),
            data: JSON.parse(categoryEl.getAttribute('data-values') || '[]'),
            dates: JSON.parse(memberEl.getAttribute('data-dates') || '[]'),
            counts: JSON.parse(memberEl.getAttribute('data-counts') || '[]')
        };
    }

    function initCategoryChart() {
        const element = document.querySelector('#categoryChart');
        if (!element) return;

        const chartData = getChartData();
        if (!chartData) return;

        // Destroy chart lama jika ada
        if (categoryChart) {
            try {
                categoryChart.destroy();
            } catch(e) {
                console.log('Chart cleanup');
            }
            categoryChart = null;
        }

        const options = {
            chart: {
                type: 'bar',
                height: 350,
                toolbar: { show: false },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800
                }
            },
            series: [{
                name: 'Jumlah Buku',
                data: chartData.data
            }],
            plotOptions: {
                bar: {
                    borderRadius: 10,
                    columnWidth: '60%',
                    distributed: true,
                    dataLabels: { position: 'top' }
                }
            },
            colors: ['#7c3aed', '#2563eb', '#16a34a', '#f59e0b', '#ef4444', '#ec4899', '#8b5cf6'],
            dataLabels: {
                enabled: true,
                offsetY: -25,
                style: {
                    fontSize: '12px',
                    fontWeight: 'bold',
                    colors: ['#333']
                }
            },
            xaxis: {
                categories: chartData.categories,
                labels: {
                    style: {
                        fontSize: '12px',
                        fontWeight: 600
                    }
                }
            },
            yaxis: {
                labels: {
                    style: { fontSize: '12px' }
                }
            },
            legend: { show: false },
            grid: {
                borderColor: '#f1f1f1',
                strokeDashArray: 4
            },
            tooltip: {
                theme: 'light',
                y: {
                    formatter: function(val) {
                        return val + " buku";
                    }
                }
            }
        };

        categoryChart = new ApexCharts(element, options);
        categoryChart.render();
    }

    function initMemberChart() {
        const element = document.querySelector('#memberChart');
        if (!element) return;

        const chartData = getChartData();
        if (!chartData) return;

        if (memberChart) {
            try {
                memberChart.destroy();
            } catch(e) {
                console.log('Chart cleanup');
            }
            memberChart = null;
        }

        const options = {
            chart: {
                type: 'area',
                height: 350,
                toolbar: { show: false },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800
                }
            },
            series: [{
                name: 'Member Baru',
                data: chartData.counts
            }],
            stroke: {
                curve: 'smooth',
                width: 3
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.2,
                    stops: [0, 90, 100]
                }
            },
            colors: ['#2563eb'],
            dataLabels: { enabled: false },
            markers: {
                size: 5,
                colors: ['#2563eb'],
                strokeColors: '#fff',
                strokeWidth: 2,
                hover: { size: 7 }
            },
            xaxis: {
                categories: chartData.dates,
                labels: {
                    style: {
                        fontSize: '11px',
                        fontWeight: 600
                    },
                    rotate: -45,
                    rotateAlways: false
                }
            },
            yaxis: {
                labels: {
                    style: { fontSize: '12px' },
                    formatter: function(val) {
                        return Math.floor(val);
                    }
                },
                min: 0
            },
            grid: {
                borderColor: '#f1f1f1',
                strokeDashArray: 4
            },
            tooltip: {
                theme: 'light',
                x: { format: 'dd MMM yyyy' },
                y: {
                    formatter: function(val) {
                        return val + " member";
                    }
                }
            }
        };

        memberChart = new ApexCharts(element, options);
        memberChart.render();
    }

    function initCharts() {
        setTimeout(() => {
            initCategoryChart();
            initMemberChart();
        }, 100);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCharts);
    } else {
        initCharts();
    }

    document.addEventListener('livewire:navigated', function() {
        console.log('Livewire navigated - reinitializing charts');
        initCharts();
    });

    document.addEventListener('livewire:navigating', function() {
        console.log('Livewire navigating - cleaning up charts');
        if (categoryChart) {
            try { categoryChart.destroy(); } catch(e) {}
            categoryChart = null;
        }
        if (memberChart) {
            try { memberChart.destroy(); } catch(e) {}
            memberChart = null;
        }
    });

    document.addEventListener('livewire:updated', function() {
        console.log('Livewire updated - refreshing charts with new data');
        initCharts();
    });
})();
</script>

<style>
.text-purple {
    color: #7c3aed;
}
</style>
@endpush
