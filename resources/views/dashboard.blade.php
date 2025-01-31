<x-app-layout>
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-6 col-xl-3">
                <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-users fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Total Users</p>
                        <h6 class="mb-0">{{ $userTotal }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-table fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Total Category</p>
                        <h6 class="mb-0">{{ $categoryTotal }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-tags fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Today Tag</p>
                        <h6 class="mb-0">{{ $tagTotal }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-edit fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Total Prompt</p>
                        <h6 class="mb-0">{{ $totalPrompt }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-user-edit fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Total Active Prompt</p>
                        <h6 class="mb-0">{{ $totalActivePrompts }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fas fa-unlink fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Total Inactive Prompt</p>
                        <h6 class="mb-0">{{ $totalInactivePrompt }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                    <i class="far fa-edit fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Total Under Review Prompt</p>
                        <h6 class="mb-0">{{ $totalUnderReviewPrompt }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
