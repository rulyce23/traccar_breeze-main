<form action="{{ route('device.store') }}" method="post">
    @csrf
    <div class="grid gap-2 grid-cols-2 sm:grid-cols-2 sm:gap-6">
        <div class="col-span-2 sm:col-span-1">
            <label for="nama_domain" class="block mb-2 text-sm font-medium text-gray-900">Name</label>
            <input type="text" name="name" id="nama_domain"
                class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                required="">
        </div>
        <div class="col-span-2 sm:col-span-1">
            <label for="epp_code" class="block mb-2 text-sm font-medium text-gray-900">Imei</label>
            <input type="text" name="uniqueId" id="epp_code"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
        </div>
        <div class="col-span-2 sm:col-span-1">
            <label for="epp_code" class="block mb-2 text-sm font-medium text-gray-900">Phone</label>
            <input type="text" name="phone" id="epp_code"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
        </div>
    </div>
    <button type="submit"
        class="dark:bg-gray-600 text-gray-200 p-3 rounded shadow-sm focus:outline-none bg-blue-900 hover:bg-blue-700 inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center focus:ring-4 focus:ring-primary-200">
        Tambah Domain
    </button>
</form>
