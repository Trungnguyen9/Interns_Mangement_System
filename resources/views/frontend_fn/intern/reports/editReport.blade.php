@extends('frontend_fn.layout.app')
@section('content')

```
{{-- ==================== PAGE BREADCRUMB ==================== --}}
<div class="page-breadcrumb">
    <div class="row">

        <div class="col-5 align-self-center">
            <h4 class="page-title">Weekly Reports</h4>
        </div>

        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">

                        <li class="breadcrumb-item">
                            <a href="{{ route('frontend.intern.reports') }}">
                                Weekly Reports
                            </a>
                        </li>

                        <li class="breadcrumb-item active">
                            Edit
                        </li>

                    </ol>
                </nav>

            </div>
        </div>

    </div>
</div>


{{-- ==================== MAIN CONTENT ==================== --}}
<div class="container-fluid">

    {{-- Success --}}
    @if (session('success'))
        <div class="alert alert-success">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif


    {{-- Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">

            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif


    <div class="row">
        <div class="col-12">

            {{-- ==================== EDIT REPORT CARD ==================== --}}
            <div class="card">

                <div class="card-body">

                    {{-- Header --}}
                    <div class="d-flex align-items-center justify-content-between mb-4">

                        <div>
                            <h4 class="card-title mb-1">
                                <i class="fa-solid fa-pen-to-square"></i>
                                Edit Weekly Report
                            </h4>

                            <p class="text-muted mb-0">
                                Update the report content before the Mentor reviews it
                            </p>
                        </div>

                        <a href="{{ route('frontend.intern.reports') }}"
                            class="btn btn-outline-secondary">

                            <i class="fa-solid fa-arrow-left"></i>
                            Back

                        </a>

                    </div>


                    {{-- ==================== EDIT FORM ==================== --}}
                    <form method="POST">

                        @csrf


                        {{-- Week dates --}}
                        <div class="row">

                            {{-- Start date --}}
                            <div class="col-md-6">

                                <div class="form-group">

                                    <label for="week_start_date">
                                        Week Start Date
                                    </label>

                                    <input
                                        type="date"
                                        id="week_start_date"
                                        name="week_start_date"
                                        class="form-control"
                                        value="{{ old('week_start_date', $reports->week_start_date) }}"
                                    >

                                </div>

                            </div>


                            {{-- End date --}}
                            <div class="col-md-6">

                                <div class="form-group">

                                    <label for="week_end_date">
                                        Week End Date
                                    </label>

                                    <input
                                        type="date"
                                        id="week_end_date"
                                        name="week_end_date"
                                        class="form-control"
                                        value="{{ old('week_end_date', $reports->week_end_date) }}"
                                    >

                                </div>

                            </div>

                        </div>


                        {{-- Completed tasks --}}
                        <div class="form-group">

                            <label for="completed_tasks">
                                Completed Tasks
                            </label>

                            <textarea
                                id="completed_tasks"
                                name="completed_tasks"
                                class="form-control"
                                rows="3"
                                placeholder="List the tasks completed this week..."
                            >{{ old('completed_tasks', $reports->completed_tasks) }}</textarea>

                        </div>


                        {{-- Difficulties --}}
                        <div class="form-group">

                            <label for="difficulties">
                                Difficulties Encountered
                            </label>

                            <textarea
                                id="difficulties"
                                name="difficulties"
                                class="form-control"
                                rows="3"
                                placeholder="Describe any difficulties encountered..."
                            >{{ old('difficulties', $reports->difficulties) }}</textarea>

                        </div>


                        {{-- Next week plan --}}
                        <div class="form-group">

                            <label for="next_plan">
                                Next Week's Plan
                            </label>

                            <textarea
                                id="next_plan"
                                name="next_plan"
                                class="form-control"
                                rows="3"
                                placeholder="Describe what you plan to do next week..."
                            >{{ old('next_plan', $reports->next_plan) }}</textarea>

                        </div>


                        {{-- Reference links --}}
                        <div class="form-group">

                            <label for="reference_links">
                                Reference Links

                                <small class="text-muted">
                                    (Optional)
                                </small>
                            </label>

                            <input
                                type="text"
                                id="reference_links"
                                name="reference_links"
                                class="form-control"
                                placeholder="https://laravel.com/docs, https://github.com/..."
                                value="{{ old('reference_links', $reports->reference_links) }}"
                            >

                        </div>


                        <hr>


                        {{-- ==================== ACTIONS ==================== --}}
                        <div class="d-flex justify-content-end">

                            <a
                                href="{{ route('frontend.intern.reports') }}"
                                class="btn btn-outline-secondary mr-2"
                            >
                                <i class="fa-solid fa-xmark"></i>
                                Cancel
                            </a>

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                <i class="fa-solid fa-floppy-disk"></i>
                                Update Report
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>

</div>
```

@endsection
