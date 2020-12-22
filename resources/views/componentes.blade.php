<!DOCTYPE html>
<html>
<head>
	<title>Prueba</title>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--bg-opacity:1;background-color:#fff;background-color:rgba(255,255,255,var(--bg-opacity))}.bg-gray-100{--bg-opacity:1;background-color:#f7fafc;background-color:rgba(247,250,252,var(--bg-opacity))}.border-gray-200{--border-opacity:1;border-color:#edf2f7;border-color:rgba(237,242,247,var(--border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{box-shadow:0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0 rgba(0,0,0,.06)}.text-center{text-align:center}.text-gray-200{--text-opacity:1;color:#edf2f7;color:rgba(237,242,247,var(--text-opacity))}.text-gray-300{--text-opacity:1;color:#e2e8f0;color:rgba(226,232,240,var(--text-opacity))}.text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.text-gray-500{--text-opacity:1;color:#a0aec0;color:rgba(160,174,192,var(--text-opacity))}.text-gray-600{--text-opacity:1;color:#718096;color:rgba(113,128,150,var(--text-opacity))}.text-gray-700{--text-opacity:1;color:#4a5568;color:rgba(74,85,104,var(--text-opacity))}.text-gray-900{--text-opacity:1;color:#1a202c;color:rgba(26,32,44,var(--text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--bg-opacity:1;background-color:#2d3748;background-color:rgba(45,55,72,var(--bg-opacity))}.dark\:bg-gray-900{--bg-opacity:1;background-color:#1a202c;background-color:rgba(26,32,44,var(--bg-opacity))}.dark\:border-gray-700{--border-opacity:1;border-color:#4a5568;border-color:rgba(74,85,104,var(--border-opacity))}.dark\:text-white{--text-opacity:1;color:#fff;color:rgba(255,255,255,var(--text-opacity))}.dark\:text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}}
    </style>

</head>
	<body class="antialiased font-sans bg-gray-200">

		<!-- TITULO -->

		<div class="container mx-auto px-4 sm:px-8 my-6">
            <h2 class="text-2xl font-semibold leading-tight">Registrar usuario</h2>
        </div>

        <!-- SUBTITULO -->

		<!-- TOPNAV -->

		<div class="container mx-auto px-4 sm:px-8">
			<nav class="bg-white px-8 pt-2 shadow-md">
			     <div class="-mb-px flex justify-center">
			         <a class="no-underline text-teal-dark border-b-2 border-teal-dark uppercase tracking-wide font-bold text-xs py-3 mr-8" href="#">
			             Home
			         </a>
			         <a class="no-underline text-grey-dark border-b-2 border-transparent uppercase tracking-wide font-bold text-xs py-3 mr-8" href="#">
			             Products
			         </a>
			         <a class="no-underline text-grey-dark border-b-2 border-transparent uppercase tracking-wide font-bold text-xs py-3 mr-8" href="#">
			             Discounts
			         </a>
			         <a class="no-underline text-grey-dark border-b-2 border-transparent uppercase tracking-wide font-bold text-xs py-3" href="#">
			             Customers
			         </a>
			     </div>
			</nav>
		</div>

	 	<!-- FORMULARIO -->

	    <div class="container mx-auto px-4 sm:px-8">
	    	<div class="bg-white shadow-md rounded pt-6 pb-8 px-4 sm:px-8 my-2 mb-4">
		  	
			  	<div class="-mx-3 md:flex mb-6">
			    	<div class="md:w-1/2 px-3 mb-6 md:mb-0">
			      		<label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-first-name">
			        		First Name
			      		</label>
			      		<input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" id="grid-first-name" type="text" placeholder="Jane">
			    	</div>

			    	<div class="md:w-1/2 px-3">
			      		<label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-last-name">
			        		Last Name
			      		</label>
			      		<input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4" id="grid-last-name" type="text" placeholder="Doe">
			    	</div>
			  	</div>

			  	<div class="-mx-3 md:flex mb-6">
			    	<div class="md:w-full px-3">
			      		<label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-password">
			        		Password
			      		</label>
			      		<input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3" id="grid-password" type="password" placeholder="******************">
			      		<p class="text-grey-dark text-xs italic">Make it as long and as crazy as you'd like</p>
			    	</div>
			  	</div>

			  	<div class="-mx-3 md:flex mb-2">
			    	<div class="md:w-1/2 px-3 mb-6 md:mb-0">
			      		<label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-city">
			        		City
			      		</label>
			      		<input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4" id="grid-city" type="text" placeholder="Albuquerque">
			    	</div>

			    	<div class="md:w-1/2 px-3">
			      		<label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-state">
			        		State
			      		</label>
			      		<div class="relative">
			        		<select class="form-select mt-1 block w-full">
			          			<option>New Mexico</option>
			          			<option>Missouri</option>
			          			<option>Texas</option>
			        		</select>
			      		</div>
			    	</div>
			  	</div>

			</div>
	    </div>

	    <!-- BOTONES -->

		    <div class="w-full text-center mx-auto">
				<button type="button" class="border border-indigo-500 bg-indigo-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-indigo-700 focus:outline-none focus:shadow-outline">
					Primary
				</button>

				<button type="button" class="border border-green-500 bg-green-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-green-700 focus:outline-none focus:shadow-outline">
					Success
				</button>

				<button type="button" class="border border-red-500 bg-red-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline">
					Error
				</button>

				<button type="button" class="border border-yellow-500 bg-yellow-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-yellow-700 focus:outline-none focus:shadow-outline">
					Warning
				</button>

				<button type="button" class="border border-gray-500 bg-gray-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-gray-700 focus:outline-none focus:shadow-outline">
					Info
				</button>

				<button type="button" class="border border-gray-700 bg-gray-700 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-gray-500 focus:outline-none focus:shadow-outline">
					Dark
				</button>

				<button type="button" class="border border-gray-200 bg-gray-200 text-gray-700 rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-gray-400 focus:outline-none focus:shadow-outline">
					Light
				</button>
		    </div>

		 <!-- DROPDOWN MENU -->

		<div class="container mx-auto px-4 sm:px-8 my-2">
			<div class="relative inline-flex float-right">
				<svg class="w-2 h-2 absolute top-0 right-0 m-4 pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 412 232">
					<path d="M206 171.144L42.678 7.822c-9.763-9.763-25.592-9.763-35.355 0-9.763 9.764-9.763 25.592 0 35.355l181 181c4.88 4.882 11.279 7.323 17.677 7.323s12.796-2.441 17.678-7.322l181-181c9.763-9.764 9.763-25.592 0-35.355-9.763-9.763-25.592-9.763-35.355 0L206 171.144z" fill="#648299" fill-rule="nonzero"/>
				</svg>

				<select class="border border-gray-300 rounded-full text-gray-600 h-10 pl-5 pr-10 bg-white hover:border-gray-400 focus:outline-none appearance-none">
					<option>Choose a color</option>
					<option>Red</option>
					<option>Blue</option>
					<option>Yellow</option>
					<option>Black</option>
					<option>Orange</option>
					<option>Purple</option>
					<option>Gray</option>
					<option>White</option>
				</select>
			</div>
		</div><br><br>

	    <!-- ALERTAS -->

	    <div class="bg-green-200 px-6 py-4 mx-2 my-4 rounded-md text-lg flex items-center mx-auto w-3/4 xl:w-2/4">
	      	<svg viewBox="0 0 24 24" class="text-green-600 w-5 h-5 sm:w-5 sm:h-5 mr-3">
	        	<path fill="currentColor" d="M12,0A12,12,0,1,0,24,12,12.014,12.014,0,0,0,12,0Zm6.927,8.2-6.845,9.289a1.011,1.011,0,0,1-1.43.188L5.764,13.769a1,1,0,1,1,1.25-1.562l4.076,3.261,6.227-8.451A1,1,0,1,1,18.927,8.2Z"
	              ></path>
	      	</svg>
	      <span class="text-green-800"> Your account has been saved. </span>
	    </div>
	    <!-- End Alert Success -->

	    <!-- Alert Error -->
	    <div class="bg-red-200 px-6 py-4 mx-2 my-4 rounded-md text-lg flex items-center mx-auto w-3/4 xl:w-2/4">
	      	<svg viewBox="0 0 24 24" class="text-red-600 w-5 h-5 sm:w-5 sm:h-5 mr-3">
	        	<path fill="currentColor" d="M11.983,0a12.206,12.206,0,0,0-8.51,3.653A11.8,11.8,0,0,0,0,12.207,11.779,11.779,0,0,0,11.8,24h.214A12.111,12.111,0,0,0,24,11.791h0A11.766,11.766,0,0,0,11.983,0ZM10.5,16.542a1.476,1.476,0,0,1,1.449-1.53h.027a1.527,1.527,0,0,1,1.523,1.47,1.475,1.475,0,0,1-1.449,1.53h-.027A1.529,1.529,0,0,1,10.5,16.542ZM11,12.5v-6a1,1,0,0,1,2,0v6a1,1,0,1,1-2,0Z"
	              ></path>
	      	</svg>
	      	<span class="text-red-800"> Your email address is invalid. </span>
	    </div>
	    <!-- End Alert Error -->

	    <!-- Alert Warning -->
	    <div class="bg-yellow-400 px-6 py-4 my-4 rounded-md text-lg flex items-center mx-auto w-3/4 xl:w-2/4">
	      	<svg viewBox="0 0 24 24" class="text-yellow-600 w-5 h-5 sm:w-5 sm:h-5 mr-3">
	        	<path fill="currentColor" d="M23.119,20,13.772,2.15h0a2,2,0,0,0-3.543,0L.881,20a2,2,0,0,0,1.772,2.928H21.347A2,2,0,0,0,23.119,20ZM11,8.423a1,1,0,0,1,2,0v6a1,1,0,1,1-2,0Zm1.05,11.51h-.028a1.528,1.528,0,0,1-1.522-1.47,1.476,1.476,0,0,1,1.448-1.53h.028A1.527,1.527,0,0,1,13.5,18.4,1.475,1.475,0,0,1,12.05,19.933Z"
	              ></path>
	      	</svg>
	      	<span class="text-yellow-800">
	        	You are currently on the Free plan.
	      	</span>
	    </div>
	    <!-- End Alert Warning -->

	    <!-- Alert Info -->
    	<div class="bg-blue-200 px-6 py-4 mx-2 my-4 rounded-md text-lg flex items-center mx-auto w-3/4 xl:w-2/4">
	      	<svg viewBox="0 0 24 24" class="text-blue-600 w-5 h-5 sm:w-5 sm:h-5 mr-3">
	        	<path fill="currentColor" d="M12,0A12,12,0,1,0,24,12,12.013,12.013,0,0,0,12,0Zm.25,5a1.5,1.5,0,1,1-1.5,1.5A1.5,1.5,0,0,1,12.25,5ZM14.5,18.5h-4a1,1,0,0,1,0-2h.75a.25.25,0,0,0,.25-.25v-4.5a.25.25,0,0,0-.25-.25H10.5a1,1,0,0,1,0-2h1a2,2,0,0,1,2,2v4.75a.25.25,0,0,0,.25.25h.75a1,1,0,1,1,0,2Z"
	              ></path>
	      	</svg>
	      	<span class="text-blue-800"> We've updated a few things. </span>
	    </div>

		<!-- TABLA -->


	    <div class="container mx-auto px-4 sm:px-8">
	        <div class="py-8">
	            <div>
	                <h2 class="text-2xl font-semibold leading-tight">Users</h2>
	            </div>

	            <div class="my-2 flex sm:flex-row flex-col">
	                <div class="flex flex-row mb-1 sm:mb-0">
	                    <div class="relative">
	                        <select
	                            class="appearance-none h-full rounded-l border block appearance-none w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
	                            <option>5</option>
	                            <option>10</option>
	                            <option>20</option>
	                        </select>
	                        <div
	                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
	                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
	                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
	                            </svg>
	                        </div>
	                    </div>
	                    <div class="relative">
	                        <select
	                            class="appearance-none h-full rounded-r border-t sm:rounded-r-none sm:border-r-0 border-r border-b block appearance-none w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-l focus:border-r focus:bg-white focus:border-gray-500">
	                            <option>All</option>
	                            <option>Active</option>
	                            <option>Inactive</option>
	                        </select>
	                        <div
	                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
	                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
	                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
	                            </svg>
	                        </div>
	                    </div>
	                </div>
	                <div class="block relative">
	                    <span class="h-full absolute inset-y-0 left-0 flex items-center pl-2">
	                        <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current text-gray-500">
	                            <path
	                                d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z">
	                            </path>
	                        </svg>
	                    </span>
	                    <input placeholder="Search"
	                        class="appearance-none rounded-r rounded-l sm:rounded-l-none border border-gray-400 border-b block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none" />
	                </div>
	            </div>

	            <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
	                <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
	                    <table class="min-w-full leading-normal">
	                        <thead>
	                            <tr>
	                                <th
	                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
	                                    User
	                                </th>
	                                <th
	                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
	                                    Rol
	                                </th>
	                                <th
	                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
	                                    Created at
	                                </th>
	                                <th
	                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
	                                    Status
	                                </th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                            <tr>
	                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
	                                    <div class="flex items-center">
	                                        <div class="flex-shrink-0 w-10 h-10">
	                                            <img class="w-full h-full rounded-full"
	                                                src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.2&w=160&h=160&q=80"
	                                                alt="" />
	                                        </div>
	                                        <div class="ml-3">
	                                            <p class="text-gray-900 whitespace-no-wrap">
	                                                Vera Carpenter
	                                            </p>
	                                        </div>
	                                    </div>
	                                </td>
	                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
	                                    <p class="text-gray-900 whitespace-no-wrap">Admin</p>
	                                </td>
	                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
	                                    <p class="text-gray-900 whitespace-no-wrap">
	                                        Jan 21, 2020
	                                    </p>
	                                </td>
	                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
	                                    <span
	                                        class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
	                                        <span aria-hidden
	                                            class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
	                                        <span class="relative">Activo</span>
	                                    </span>
	                                </td>
	                            </tr>
	                            <tr>
	                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
	                                    <div class="flex items-center">
	                                        <div class="flex-shrink-0 w-10 h-10">
	                                            <img class="w-full h-full rounded-full"
	                                                src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.2&w=160&h=160&q=80"
	                                                alt="" />
	                                        </div>
	                                        <div class="ml-3">
	                                            <p class="text-gray-900 whitespace-no-wrap">
	                                                Blake Bowman
	                                            </p>
	                                        </div>
	                                    </div>
	                                </td>
	                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
	                                    <p class="text-gray-900 whitespace-no-wrap">Editor</p>
	                                </td>
	                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
	                                    <p class="text-gray-900 whitespace-no-wrap">
	                                        Jan 01, 2020
	                                    </p>
	                                </td>
	                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
	                                    <span
	                                        class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
	                                        <span aria-hidden
	                                            class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
	                                        <span class="relative">Activo</span>
	                                    </span>
	                                </td>
	                            </tr>
	                            <tr>
	                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
	                                    <div class="flex items-center">
	                                        <div class="flex-shrink-0 w-10 h-10">
	                                            <img class="w-full h-full rounded-full"
	                                                src="https://images.unsplash.com/photo-1540845511934-7721dd7adec3?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.2&w=160&h=160&q=80"
	                                                alt="" />
	                                        </div>
	                                        <div class="ml-3">
	                                            <p class="text-gray-900 whitespace-no-wrap">
	                                                Dana Moore
	                                            </p>
	                                        </div>
	                                    </div>
	                                </td>
	                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
	                                    <p class="text-gray-900 whitespace-no-wrap">Editor</p>
	                                </td>
	                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
	                                    <p class="text-gray-900 whitespace-no-wrap">
	                                        Jan 10, 2020
	                                    </p>
	                                </td>
	                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
	                                    <span
	                                        class="relative inline-block px-3 py-1 font-semibold text-orange-900 leading-tight">
	                                        <span aria-hidden
	                                            class="absolute inset-0 bg-orange-200 opacity-50 rounded-full"></span>
	                                        <span class="relative">Suspended</span>
	                                    </span>
	                                </td>
	                            </tr>
	                            <tr>
	                                <td class="px-5 py-5 bg-white text-sm">
	                                    <div class="flex items-center">
	                                        <div class="flex-shrink-0 w-10 h-10">
	                                            <img class="w-full h-full rounded-full"
	                                                src="https://images.unsplash.com/photo-1522609925277-66fea332c575?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.2&h=160&w=160&q=80"
	                                                alt="" />
	                                        </div>
	                                        <div class="ml-3">
	                                            <p class="text-gray-900 whitespace-no-wrap">
	                                                Alonzo Cox
	                                            </p>
	                                        </div>
	                                    </div>
	                                </td>
	                                <td class="px-5 py-5 bg-white text-sm">
	                                    <p class="text-gray-900 whitespace-no-wrap">Admin</p>
	                                </td>
	                                <td class="px-5 py-5 bg-white text-sm">
	                                    <p class="text-gray-900 whitespace-no-wrap">Jan 18, 2020</p>
	                                </td>
	                                <td class="px-5 py-5 bg-white text-sm">
	                                    <span
	                                        class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
	                                        <span aria-hidden
	                                            class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
	                                        <span class="relative">Inactive</span>
	                                    </span>
	                                </td>
	                            </tr>
	                        </tbody>
	                    </table>
	                    <div
	                        class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between          ">
	                        <span class="text-xs xs:text-sm text-gray-900">
	                            Showing 1 to 4 of 50 Entries
	                        </span>
	                        <div class="inline-flex mt-2 xs:mt-0">
	                            <button
	                                class="text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-l">
	                                Prev
	                            </button>
	                            <button
	                                class="text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-r">
	                                Next
	                            </button>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>


		<!-- LISTAS -->
		<!-- <div class="container mx-auto px-4 sm:px-8">
			<ul class="px-0 bg-white rounded-lg">
				<li class="border list-none px-3 py-3">List Item 1</li>
				<li class="border list-none px-3 py-3">List Item 1</li>
				<li class="border list-none px-3 py-3">List Item 1</li>
				<li class="border list-none px-3 py-3">List Item 1</li>
				<li class="border list-none px-3 py-3">List Item 1</li>
			</ul>
		</div> -->
		<div class="container mx-auto px-4 sm:px-8">
			<ul class="bg-white border border-blue-100 rounded-md divide-y divide-gray-200">

	        	<li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
	          		<div class="w-0 flex-1 flex items-center">
		                <span class="ml-2 flex-1 w-0 truncate">
		                  resume_back_end_developer.pdf
		                </span>
	          		</div>

	          		<div class="ml-4 flex-shrink-0">
		                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
		                  Download
		                </a>
	          		</div>
	        	</li>

	      	</ul>
	    </div>

		<!-- DESCRIPCION DE ALGO EN PARTICULAR -->
		<div class="container mx-auto px-4 sm:px-8 my-6">
			<div class="bg-white shadow overflow-hidden sm:rounded-lg">
		  		<div class="px-4 py-5 sm:px-6">
				    <h3 class="text-lg leading-6 font-medium text-gray-900">
				    	Applicant Information
				    </h3>
				    <p class="mt-1 max-w-2xl text-sm text-gray-500">
				    	Personal details and application.
				    </p>
			  	</div>

			  	<div class="border-t border-gray-200">
				    <dl>
			      		<div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
				        	<dt class="text-sm font-medium text-gray-500">
				          		Full name
				        	</dt>

				        	<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
				          		Margot Foster
				        	</dd>
				      	</div>
				      
				      	<div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
					        <dt class="text-sm font-medium text-gray-500">
					          Application for
					        </dt>
					        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
					          Backend Developer
					        </dd>
				      	</div>
				      
				      	<div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
					        
					        <dt class="text-sm font-medium text-gray-500">
					          Attachments
					        </dt>

					        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
					          	<ul class="border border-gray-200 rounded-md divide-y divide-gray-200">

					            	<li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
					              		<div class="w-0 flex-1 flex items-center">
					                <!-- Heroicon name: paper-clip -->
					                		<svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
					                  			<path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
					                		</svg>

							                <span class="ml-2 flex-1 w-0 truncate">
							                  resume_back_end_developer.pdf
							                </span>
					              		</div>

					              		<div class="ml-4 flex-shrink-0">
							                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
							                  Download
							                </a>
					              		</div>
					            	</li>

					          	</ul>
					        </dd>

				      	</div>
				    </dl>
			  	</div>
			</div>
		</div>
	    
	</body>
</html>