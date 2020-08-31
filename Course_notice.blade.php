1) validation
        $request->validate([
            'name' => 'required|unique:categories'
        ]);

2) Form Request validattion :

    1-php artisan make:request NameRequest
    2-go to Request Page ->   false => true   && write rules

    # to customize the Error msg =>

        public function messages()
    {
        return [
            'name.unique' => 'A title is required',
        ];
    }


3) Create Method :

    - define $fillable = [] in the Model
    - Category:create($request->all())
    or Category:create([
        name => $request->name,
    ]);

4) Make Session :

in Controller  => session()->flash('success' , 'mes..');

in View  =>
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session(->get('success')) }}
            </div>
        @endif

