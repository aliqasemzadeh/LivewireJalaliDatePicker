<div class="p-4 h-auto pt-10">
    <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
        <h5 class="text-xl font-medium text-gray-900 dark:text-white mb-4">Jalali Date Picker Example</h5>

        <form class="space-y-4 md:space-y-6" wire:submit="save">
            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selected Date</label>
                <div class="flex items-center space-x-2">
                    <livewire:jalali-date-picker
                        wire:model="date"
                        :year-input="$yearInputMode"
                        :default-today="true"
                        :inline-layout="$inlineLayoutMode"
                    />
                </div>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    Current value: <span class="font-medium" x-text="$wire.date || 'Not selected'"></span>
                </p>
            </div>

            <div class="flex items-center mb-4">
                <input
                    id="year-input-checkbox"
                    type="checkbox"
                    wire:model.live="yearInputMode"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                >
                <label for="year-input-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                    Use year input field instead of dropdown
                </label>
            </div>

            <div class="flex items-center mb-4">
                <input
                    id="inline-layout-checkbox"
                    type="checkbox"
                    wire:model.live="inlineLayoutMode"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                >
                <label for="inline-layout-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                    Use inline layout (row) instead of column layout
                </label>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Save Date
                </button>
            </div>
        </form>
    </div>

    <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700 mt-6">
        <h5 class="text-xl font-medium text-gray-900 dark:text-white mb-4">How to Use</h5>

        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
            <pre class="text-sm text-gray-900 dark:text-gray-300 overflow-x-auto">
&lt;livewire:jalali-date-picker
    wire:model="date"
    :year-input="true|false"
    :default-today="true|false"
    :inline-layout="true|false"
/&gt;
            </pre>
        </div>

        <div class="mt-4">
            <h6 class="text-lg font-medium text-gray-900 dark:text-white">Properties:</h6>
            <ul class="list-disc list-inside text-sm text-gray-700 dark:text-gray-300 mt-2">
                <li><strong>wire:model</strong> - The property to bind the selected date to</li>
                <li><strong>year-input</strong> - Whether to use an input field for the year (true) or a dropdown (false)</li>
                <li><strong>default-today</strong> - Whether to default to today's date if no value is provided</li>
                <li><strong>inline-layout</strong> - Whether to display inputs in a row (true) or in columns (false)</li>
            </ul>
        </div>
    </div>
</div>
