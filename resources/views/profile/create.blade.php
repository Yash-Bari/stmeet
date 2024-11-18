@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12 px-6 sm:px-12">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-8 space-y-6">
        <h1 class="text-3xl font-bold text-center text-gray-900">Create Your Profile</h1>

        <form method="POST" action="{{ route('profile.store') }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Gender Field -->
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                    <select id="gender" name="gender" class="mt-1 block w-full px-4 py-2 bg-gray-100 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <!-- Age Field -->
                <div>
                    <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
                    <input type="number" id="age" name="age" value="{{ old('age') }}" class="mt-1 block w-full px-4 py-2 bg-gray-100 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                </div>
            </div>

            <!-- Interests Field -->
            <div>
                <label for="interests" class="block text-sm font-medium text-gray-700">Interests</label>
                <select id="interests" name="interests[]" multiple class="mt-1 block w-full px-4 py-2 bg-gray-100 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="technology" {{ in_array('technology', old('interests', [])) ? 'selected' : '' }}>Technology</option>
                    <option value="music" {{ in_array('music', old('interests', [])) ? 'selected' : '' }}>Music</option>
                    <option value="sports" {{ in_array('sports', old('interests', [])) ? 'selected' : '' }}>Sports</option>
                    <option value="art" {{ in_array('art', old('interests', [])) ? 'selected' : '' }}>Art</option>
                    <option value="traveling" {{ in_array('traveling', old('interests', [])) ? 'selected' : '' }}>Traveling</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="mt-8 flex justify-center">
                <button type="submit" class="w-full sm:w-48 py-3 px-6 bg-indigo-600 text-white font-semibold text-lg rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Create Profile
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
