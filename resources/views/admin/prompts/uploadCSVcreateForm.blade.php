<x-app-layout>
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4">Bulk Upload Via CSV</h6>
                    <form action="{{ route('admin.prompts.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="csv_file" class="form-label">Upload CSV File</label>
                            <input type="file" class="form-control" id="csv_file" name="csv_file">
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
