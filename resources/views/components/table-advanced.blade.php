<div class="flex flex-col mt-2">
    <div class="align-middle min-w-full overflow-x-auto shadow overflow-hidden sm:rounded-lg">
        <table class="min-w-full divide-y divide-cool-gray-200">
            <thead>
            <tr>
                {{ $head }}
                {{--<th class="px-6 py-3 bg-cool-gray-50 text-left text-xs leading-4 font-medium text-cool-gray-500 uppercase tracking-wider">--}}
                    {{--Transaction--}}
                {{--</th>--}}
                {{--<th class="px-6 py-3 bg-cool-gray-50 text-right text-xs leading-4 font-medium text-cool-gray-500 uppercase tracking-wider">--}}
                    {{--Amount--}}
                {{--</th>--}}
                {{--<th class="hidden px-6 py-3 bg-cool-gray-50 text-left text-xs leading-4 font-medium text-cool-gray-500 uppercase tracking-wider md:block">--}}
                    {{--Status--}}
                {{--</th>--}}
                {{--<th class="px-6 py-3 bg-cool-gray-50 text-right text-xs leading-4 font-medium text-cool-gray-500 uppercase tracking-wider">--}}
                    {{--Date--}}
                {{--</th>--}}
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-cool-gray-200">
            {{ $body }}
            {{--<tr class="bg-white">--}}
                {{--<td class="max-w-0 w-full px-6 py-4 whitespace-no-wrap text-sm leading-5 text-cool-gray-900">--}}
                    {{--<div class="flex">--}}
                        {{--<a href="#" class="group inline-flex space-x-2 truncate text-sm leading-5">--}}
                            {{--<!-- Heroicon name: cash -->--}}
                            {{--<svg class="flex-shrink-0 h-5 w-5 text-cool-gray-400 group-hover:text-cool-gray-500 transition ease-in-out duration-150" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">--}}
                                {{--<path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />--}}
                            {{--</svg>--}}
                            {{--<p class="text-cool-gray-500 truncate group-hover:text-cool-gray-900 transition ease-in-out duration-150">--}}
                                {{--Payment to Molly Sanders--}}
                            {{--</p>--}}
                        {{--</a>--}}
                    {{--</div>--}}
                {{--</td>--}}
                {{--<td class="px-6 py-4 text-right whitespace-no-wrap text-sm leading-5 text-cool-gray-500">--}}
                    {{--<span class="text-cool-gray-900 font-medium">$20,000 </span>--}}
                    {{--USD--}}
                {{--</td>--}}
                {{--<td class="hidden px-6 py-4 whitespace-no-wrap text-sm leading-5 text-cool-gray-500 md:block">--}}
                    {{--<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 bg-green-100 text-green-800 capitalize">--}}
                      {{--success--}}
                    {{--</span>--}}
                {{--</td>--}}
                {{--<td class="px-6 py-4 text-right whitespace-no-wrap text-sm leading-5 text-cool-gray-500">--}}
                    {{--July 11, 2020--}}
                {{--</td>--}}
            {{--</tr>--}}

            <!-- More rows... -->
            </tbody>
        </table>
        <!-- Pagination -->
        <nav class="bg-white px-4 py-3 flex items-center justify-between border-t border-cool-gray-200 sm:px-6">
            <div class="hidden sm:block">
                <p class="text-sm leading-5 text-cool-gray-700">
                    Showing
                    <span class="font-medium">1</span>
                    to
                    <span class="font-medium">10</span>
                    of
                    <span class="font-medium">20</span>
                    results
                </p>
            </div>
            <div class="flex-1 flex justify-between sm:justify-end">
                <a href="#" class="relative inline-flex items-center px-4 py-2 border border-cool-gray-300 text-sm leading-5 font-medium rounded-md text-cool-gray-700 bg-white hover:text-cool-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-cool-gray-100 active:text-cool-gray-700 transition ease-in-out duration-150">
                    Previous
                </a>
                <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-cool-gray-300 text-sm leading-5 font-medium rounded-md text-cool-gray-700 bg-white hover:text-cool-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-cool-gray-100 active:text-cool-gray-700 transition ease-in-out duration-150">
                    Next
                </a>
            </div>
        </nav>
    </div>
</div>
