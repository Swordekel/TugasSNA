@extends('template.structured', ['title' => 'Update Room'])

@section('contents')
    <div class="w-full">
        @include('components.admin-header')
        <div class="w-full max-w-3xl rounded container mx-auto mt-4 p-3 bg-white shadow-md">
            <div>
                <span class="font-bold text-xl">Update Room</span>
            </div>
            <form class="mt-4" action="{{ route('admin.rooms.update', ['room' => $room]) }}" method="POST">
                @csrf
                @method('PATCH')

                <div>
                    <label class="font-bold block text-gray-700 my-2" for="room-type">
                        Room Type
                    </label>
                    <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight @error('room_type') border-red-500 @enderror focus:outline-none focus:ring" name="room_type" id="room-type">
                        <option value="">-- Choose One --</option>
                        @foreach($roomTypes as $roomType)
                            <option value="{{ $roomType->id }}" @if((old('room_type') ?? $room->roomType->id) === $roomType->id) selected @endif>{{ $roomType->name }}</option>
                        @endforeach
                    </select>
                    @error('room_type')
                        <span class="text-red-500">{{ $errors->first('room_type') }}</span>
                    @enderror
                </div>
                <div>
                    <label class="font-bold block text-gray-700 my-2" for="name">
                        Name
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight @error('name') border-red-500 @enderror focus:outline-none focus:ring" id="name" name="name" type="text" placeholder="Room Name" value="{{ old('name') ?? $room->name }}">
                    @error('name')
                        <span class="text-red-500">{{ $errors->first('name') }}</span>
                    @enderror
                </div>
                <div class="mt-4">
                    <input class="shadow py-2 px-3 text-gray-700 @error('available') border-red-500 @enderror focus:outline-none focus:ring" id="available" name="available" type="checkbox" @if ((old('available') ?? $room->available) === 1) checked @endif>
                    <label class="my-2" for="available">
                        Available for Borrowing
                    </label>
                    @error('available')
                        <span class="text-red-500">{{ $errors->first('available') }}</span>
                    @enderror
                </div>
                <div class="mt-3">
                    <button class="btn bg-green-500 p-2 text-white rounded hover:bg-green-700" type="submit">
                        Update
                    </button>
                </div>
            </form>
        </div>
        <div class="w-full max-w-3xl rounded container mx-auto mt-4 p-3 bg-white shadow-md">
            <div>
                <span class="font-bold text-xl mr-2">Computer Management</span>
                <a class="btn bg-green-500 text-white p-2 rounded hover:bg-green-700" href="{{ route('admin.computers.create', ['room' => $room]) }}">
                    <x-heroicon-s-plus style="width: 20px; display: inline-block" /> Add New Computer
                </a>
            </div>
            <div>
                <table class="w-full border mt-4 shadow-md">
                    <thead>
                    <tr>
                        <th class="p-2">Hostname</th>
                        <th class="p-2">IP Address</th>
                        <th class="w-36">Action</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    @foreach ($computers as $computer)
                        <tr class="bg-gray-200">
                            <td>{{ $computer->hostname }}</td>
                            <td>{{ $computer->ip_address }}</td>
                            <th class="flex items-center justify-center">
                                <a class="mx-2 text-blue-500 hover:text-blue-700" href="{{ route('admin.computers.edit', ['computer' => $computer]) }}">
                                    <x-heroicon-s-pencil style="width: 25px;" />
                                </a>
                                <a class="mx-2 text-red-500 hover:text-red-700" href="{{ route('admin.computers.destroy', ['computer' => $computer]) }}" data-method="DELETE" data-form-_token="{{ csrf_token() }}">
                                    <x-heroicon-s-trash style="width: 25px;" />
                                </a>
                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $computers->links() }}
            </div>
        </div>
    </div>
@endsection
