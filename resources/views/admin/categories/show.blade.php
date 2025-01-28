<x-app-layout>
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4">Category Details</h6>
                    <form>
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" readonly value="{{ $category->name }}">
                        </div>
                        
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
