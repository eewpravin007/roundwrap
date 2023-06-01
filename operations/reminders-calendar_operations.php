<div class="card app-calendar-wrapper">
    <div class="row g-0">
        <!-- Calendar Sidebar -->
        <div class="col app-calendar-sidebar" id="app-calendar-sidebar">
            <div class="border-bottom p-4 my-sm-0 mb-3">
                <div class="d-grid">
                    <button
                        class="btn btn-primary btn-toggle-sidebar"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#addEventSidebar"
                        aria-controls="addEventSidebar"
                        >
                        <i class="bx bx-plus"></i>
                        <span class="align-middle">Add Event</span>
                    </button>
                </div>
            </div>
            <div class="p-4">
                <!-- inline calendar (flatpicker) -->
                <div class="ms-n2">
                    <div class="inline-calendar"></div>
                </div>

                <hr class="container-m-nx my-4" />

                <!-- Filter -->
                <div class="mb-4">
                    <small class="text-small text-muted text-uppercase align-middle">Filter</small>
                </div>

                <div class="form-check mb-2">
                    <input
                        class="form-check-input select-all"
                        type="checkbox"
                        id="selectAll"
                        data-value="all"
                        checked
                        />
                    <label class="form-check-label" for="selectAll">View All</label>
                </div>

                <div class="app-calendar-events-filter">
                    <div class="form-check form-check-danger mb-2">
                        <input
                            class="form-check-input input-filter"
                            type="checkbox"
                            id="select-personal"
                            data-value="personal"
                            checked
                            />
                        <label class="form-check-label" for="select-personal">Personal</label>
                    </div>
                    <div class="form-check mb-2">
                        <input
                            class="form-check-input input-filter"
                            type="checkbox"
                            id="select-business"
                            data-value="business"
                            checked
                            />
                        <label class="form-check-label" for="select-business">Business</label>
                    </div>
                    <div class="form-check form-check-warning mb-2">
                        <input
                            class="form-check-input input-filter"
                            type="checkbox"
                            id="select-family"
                            data-value="family"
                            checked
                            />
                        <label class="form-check-label" for="select-family">Family</label>
                    </div>
                    <div class="form-check form-check-success mb-2">
                        <input
                            class="form-check-input input-filter"
                            type="checkbox"
                            id="select-holiday"
                            data-value="holiday"
                            checked
                            />
                        <label class="form-check-label" for="select-holiday">Holiday</label>
                    </div>
                    <div class="form-check form-check-info">
                        <input
                            class="form-check-input input-filter"
                            type="checkbox"
                            id="select-etc"
                            data-value="etc"
                            checked
                            />
                        <label class="form-check-label" for="select-etc">ETC</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col app-calendar-content">
            <div class="card shadow-none border-0">
                <div class="card-body pb-0">
                    <div id="calendar"></div>
                </div>
            </div>
            <div class="app-overlay"></div>
            <div class="offcanvas offcanvas-end event-sidebar" tabindex="-1" id="addEventSidebar" aria-labelledby="addEventSidebarLabel" >
                <div class="offcanvas-header border-bottom">
                    <h6 class="offcanvas-title" id="addEventSidebarLabel">Add Event</h6>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close" ></button>
                </div>
                <div class="offcanvas-body">
                </div>
            </div>
        </div>
    </div>
</div>