@extends('layouts.app')

@section('title', 'Data Divisi')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Data Divisi</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Kelola data divisi perusahaan</p>
            </div>

            <!-- Search Bar -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <label for="searchInput" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Cari Divisi
                        </label>
                        <input type="text" id="searchInput" placeholder="Masukkan nama divisi..."
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                    </div>
                    <div class="flex items-end">
                        <button id="searchBtn"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                            <i class="fas fa-search mr-2"></i>Cari
                        </button>
                    </div>
                </div>
            </div>

            <!-- Divisions Table -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <!-- Loading State -->
                <div id="loadingState" class="p-8 text-center">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
                    <p class="text-gray-600 dark:text-gray-400 mt-4">Memuat data divisi...</p>
                </div>

                <!-- Table -->
                <div id="tableContainer" class="hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        #
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Nama Divisi
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Tanggal Dibuat
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="divisionsTableBody"
                                class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                <!-- Data akan dimuat dengan JavaScript -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div
                        class="bg-white dark:bg-gray-800 px-4 py-3 flex items-center justify-between border-t border-gray-200 dark:border-gray-700 sm:px-6">
                        <div class="flex-1 flex justify-between sm:hidden">
                            <button id="prevBtnMobile"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                Previous
                            </button>
                            <button id="nextBtnMobile"
                                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                Next
                            </button>
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700 dark:text-gray-300">
                                    Menampilkan
                                    <span class="font-medium" id="showingFrom">0</span>
                                    sampai
                                    <span class="font-medium" id="showingTo">0</span>
                                    dari
                                    <span class="font-medium" id="totalRecords">0</span>
                                    hasil
                                </p>
                            </div>
                            <div>
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" id="paginationNav">
                                    <!-- Pagination buttons akan dimuat dengan JavaScript -->
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div id="emptyState" class="hidden p-8 text-center">
                    <div class="mx-auto h-24 w-24 text-gray-400 mb-4">
                        <i class="fas fa-building text-6xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Tidak ada data divisi</h3>
                    <p class="text-gray-500 dark:text-gray-400">Belum ada divisi yang terdaftar atau sesuai dengan pencarian
                        Anda.</p>
                </div>

                <!-- Error State -->
                <div id="errorState" class="hidden p-8 text-center">
                    <div class="mx-auto h-24 w-24 text-red-400 mb-4">
                        <i class="fas fa-exclamation-triangle text-6xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Terjadi Kesalahan</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-4">Gagal memuat data divisi. Silakan coba lagi.</p>
                    <button id="retryBtn"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 transition duration-200">
                        Coba Lagi
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        class DivisionManager {
            constructor() {
                this.currentPage = 1;
                this.searchQuery = '';
                this.init();
            }

            init() {
                this.bindEvents();
                this.loadDivisions();
            }

            bindEvents() {
                // Search functionality
                document.getElementById('searchBtn').addEventListener('click', () => {
                    this.handleSearch();
                });

                document.getElementById('searchInput').addEventListener('keypress', (e) => {
                    if (e.key === 'Enter') {
                        this.handleSearch();
                    }
                });

                // Retry button
                document.getElementById('retryBtn').addEventListener('click', () => {
                    this.loadDivisions();
                });
            }

            handleSearch() {
                this.searchQuery = document.getElementById('searchInput').value.trim();
                this.currentPage = 1;
                this.loadDivisions();
            }

            async loadDivisions() {
                try {
                    this.showLoading();

                    const params = new URLSearchParams({
                        page: this.currentPage
                    });

                    if (this.searchQuery) {
                        params.append('name', this.searchQuery);
                    }

                    const response = await fetch(`/api/divisions?${params.toString()}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }

                    const data = await response.json();

                    if (data.status === 'success') {
                        this.renderDivisions(data.data.divisions, data.pagination);
                    } else {
                        throw new Error(data.message || 'Unknown error');
                    }
                } catch (error) {
                    console.error('Error loading divisions:', error);
                    this.showError();
                }
            }

            showLoading() {
                document.getElementById('loadingState').classList.remove('hidden');
                document.getElementById('tableContainer').classList.add('hidden');
                document.getElementById('emptyState').classList.add('hidden');
                document.getElementById('errorState').classList.add('hidden');
            }

            showError() {
                document.getElementById('loadingState').classList.add('hidden');
                document.getElementById('tableContainer').classList.add('hidden');
                document.getElementById('emptyState').classList.add('hidden');
                document.getElementById('errorState').classList.remove('hidden');
            }

            renderDivisions(divisions, pagination) {
                document.getElementById('loadingState').classList.add('hidden');
                document.getElementById('errorState').classList.add('hidden');

                if (divisions.length === 0) {
                    document.getElementById('tableContainer').classList.add('hidden');
                    document.getElementById('emptyState').classList.remove('hidden');
                    return;
                }

                document.getElementById('emptyState').classList.add('hidden');
                document.getElementById('tableContainer').classList.remove('hidden');

                // Render table rows
                const tbody = document.getElementById('divisionsTableBody');
                tbody.innerHTML = divisions.map((division, index) => {
                    const rowNumber = ((pagination.current_page - 1) * pagination.per_page) + index + 1;
                    const createdAt = new Date(division.created_at).toLocaleDateString('id-ID', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });

                    return `
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                        ${rowNumber}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                    <i class="fas fa-building text-blue-600 dark:text-blue-400"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    ${division.name}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        ${createdAt}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 mr-3">
                            <i class="fas fa-eye"></i> Detail
                        </button>
                        <button class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 mr-3">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </td>
                </tr>
            `;
                }).join('');

                // Update pagination info
                document.getElementById('showingFrom').textContent = pagination.from || 0;
                document.getElementById('showingTo').textContent = pagination.to || 0;
                document.getElementById('totalRecords').textContent = pagination.total;

                // Render pagination
                this.renderPagination(pagination);
            }

            renderPagination(pagination) {
                const nav = document.getElementById('paginationNav');
                const buttons = [];

                // Previous button
                if (pagination.current_page > 1) {
                    buttons.push(`
                <button onclick="divisionManager.goToPage(${pagination.current_page - 1})"
                    class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm font-medium text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <i class="fas fa-chevron-left"></i>
                </button>
            `);
                }

                // Page numbers
                const startPage = Math.max(1, pagination.current_page - 2);
                const endPage = Math.min(pagination.last_page, pagination.current_page + 2);

                for (let i = startPage; i <= endPage; i++) {
                    const isActive = i === pagination.current_page;
                    buttons.push(`
                <button onclick="divisionManager.goToPage(${i})"
                    class="relative inline-flex items-center px-4 py-2 border text-sm font-medium
                    ${isActive
                        ? 'z-10 bg-blue-50 dark:bg-blue-900 border-blue-500 text-blue-600 dark:text-blue-400'
                        : 'bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-600'
                    }">
                    ${i}
                </button>
            `);
                }

                // Next button
                if (pagination.current_page < pagination.last_page) {
                    buttons.push(`
                <button onclick="divisionManager.goToPage(${pagination.current_page + 1})"
                    class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm font-medium text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <i class="fas fa-chevron-right"></i>
                </button>
            `);
                }

                nav.innerHTML = buttons.join('');
            }

            goToPage(page) {
                this.currentPage = page;
                this.loadDivisions();
            }
        }

        // Initialize when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            window.divisionManager = new DivisionManager();
        });
    </script>
@endsection
