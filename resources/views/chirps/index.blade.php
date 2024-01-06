
@if(session('status'))
<div class="bg-green-600 text-green-100 text-center text-lg font-bold p-2"> {{ session('status') }} </div>
@endif 

<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Chirps') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100" ">
                    {{-- @dump($errors->all()) --}}

                   <form method="POST" action="{{ route('chirps.store') }}"> 
                    @csrf
                        <textarea name="mensaje"
                                  style="width: 80%;"
                                  class="block w-ful rounded-md border-gray-300 bg-white focus:ring-opacity-50 transition-colors duration-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200  dark:border-gray-600 dark:bg-gray-800 dark:text-white  dark:focus:border-indigo-300  dark:focus:ring dark:focus:ring-indigo-200 dark:focus:ring-opacity-50"
                                  placeholder="{{ __('What\'s on your mind?') }}"
                                  >{{ old('mensaje') }}</textarea>
                                   <x-input-error :messages="$errors->get('mensaje')" class="mt-2"/>
                                    
                        <x-primary-button class="mt-4"> {{ __('Chirp') }}  </x-primary-button>
                        <br>
                   </form> 
                </div>
            </div>

            
            
            <div class=" mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg divide-y dark:divide-gray-900">
                @foreach ($chirps as $chirp )
                <div class="p-6 flex space-x-2">
                    <svg class="h-6 w-6 text-gray-600 dark:text-gray-400 -scale-x-100" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m3.75 7.5 16.5-4.125M12 6.75c-2.708 0-5.363.224-7.948.655C2.999 7.58 2.25 8.507 2.25 9.574v9.176A2.25 2.25 0 0 0 4.5 21h15a2.25 2.25 0 0 0 2.25-2.25V9.574c0-1.067-.75-1.994-1.802-2.169A48.329 48.329 0 0 0 12 6.75Zm-1.683 6.443-.005.005-.006-.005.006-.005.005.005Zm-.005 2.127-.005-.006.005-.005.005.005-.005.005Zm-2.116-.006-.005.006-.006-.006.005-.005.006.005Zm-.005-2.116-.006-.005.006-.005.005.005-.005.005ZM9.255 10.5v.008h-.008V10.5h.008Zm3.249 1.88-.007.004-.003-.007.006-.003.004.006Zm-1.38 5.126-.003-.006.006-.004.004.007-.006.003Zm.007-6.501-.003.006-.007-.003.004-.007.006.004Zm1.37 5.129-.007-.004.004-.006.006.003-.004.007Zm.504-1.877h-.008v-.007h.008v.007ZM9.255 18v.008h-.008V18h.008Zm-3.246-1.87-.007.004L6 16.127l.006-.003.004.006Zm1.366-5.119-.004-.006.006-.004.004.007-.006.003ZM7.38 17.5l-.003.006-.007-.003.004-.007.006.004Zm-1.376-5.116L6 12.38l.003-.007.007.004-.004.007Zm-.5 1.873h-.008v-.007h.008v.007ZM17.25 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Zm0 4.5a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                    </svg>
                      
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div>
                               <span class="text-gray-800 dark:text-gray-200">
                                {{ $chirp->user->name }}
                               </span>
                               <small class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{  $chirp->created_at->format('j M Y, g:i a') }}  {{ $chirp->created_at->diffforhumans()}}</small>
                               @unless ($chirp->created_at ->eq($chirp->updated_at))
                                    <small class="ml-2 text-sm text-gray-600 dark:text-gray-400"> &middot;   {{__('edited')}} </small>
                                @endunless
                            </div>
                        </div>
                        <p class="mt-4 text-lg text-gray-900 dark:text-gray-100">{{ $chirp->mensaje }}</p>
                        
                        
                    </div>
                    @can('update', $chirp)
                     <x-dropdown>
                        <x-slot name="trigger">
                            <button>
                                <svg class="w-5 h-5 text-gray-200 dark:text-gray-400"  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                              </svg>
                              </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('chirps.edit', $chirp)">
                                 {{__('Edit') }} {{ __('Chirp') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('chirps.destroy', $chirp) }}" >
                                @csrf @method('DELETE')
                            <x-dropdown-link :href="route('chirps.destroy', $chirp)" onclick="event.preventDefault(); this.closest('form').submit();">   
                                {{__('Delete') }} {{ __('Chirp') }}
                            </x-dropdown-link>
                            </form>
                                
                        </x-slot>
                    </x-dropdown>   
                    @endcan
                    
                    
                </div> 
                @endforeach
                 
            </div>


        </div>
    </div>

</x-app-layout>


