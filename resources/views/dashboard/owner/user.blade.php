@extends('layout.own')

@section('title', 'Staff and Customer List')

@section('content')
<div x-data="userManagement()" class="p-6 space-y-8">

    <!-- Add User Button -->
    <div class="flex justify-end">
        <button @click="openModal"
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg focus:ring-2 focus:ring-blue-400">
            + Add New User
        </button>
    </div>

    <!-- Staff Section -->
    <section class="bg-white p-6 rounded-lg shadow border border-blue-300">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-blue-700">Staff List</h2>
            <button @click="staffOpen = !staffOpen" class="text-blue-600 focus:outline-none">
                <span x-text="staffOpen ? 'Hide' : 'Show'"></span>
            </button>
        </div>
        <div x-show="staffOpen" x-transition>
            <input type="text" x-model="staffSearch" placeholder="Search staff..."
                class="w-full p-2 mb-4 border rounded" />
            <table class="w-full border text-left">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="p-2 border-b">ID</th>
                        <th class="p-2 border-b">Username</th>
                        <th class="p-2 border-b">Full Name</th>
                        <th class="p-2 border-b">Phone</th>
                        <th class="p-2 border-b">Role</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="staff in filteredStaffs()" :key="staff.id">
                        <tr class="hover:bg-blue-50">
                            <td class="p-2 border-b" x-text="staff.id"></td>
                            <td class="p-2 border-b" x-text="staff.username"></td>
                            <td class="p-2 border-b" x-text="staff.fullname"></td>
                            <td class="p-2 border-b" x-text="staff.phone || '-'"></td>
                            <td class="p-2 border-b align-top">
                                <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full">
                                    Staff
                                </span>

                                <div class="mt-2 flex space-x-2">
                                    <button 
                                        @click="editUser(staff)"
                                        class="flex items-center gap-1 text-yellow-600 hover:text-yellow-800 transition text-sm font-medium"
                                    >
                                        <i class="fas fa-edit"></i> Edit
                                    </button>

                                    <button 
                                        @click="deleteUser(staff.id)"
                                        class="flex items-center gap-1 text-red-600 hover:text-red-800 transition text-sm font-medium"
                                    >
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Customer Section -->
    <section class="bg-white p-6 rounded-lg shadow border border-green-300">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-green-700">Customer List</h2>
            <button @click="customerOpen = !customerOpen" class="text-green-600 focus:outline-none">
                <span x-text="customerOpen ? 'Hide' : 'Show'"></span>
            </button>
        </div>
        <div x-show="customerOpen" x-transition>
            <input type="text" x-model="customerSearch" placeholder="Search customer..."
                class="w-full p-2 mb-4 border rounded" />
            <table class="w-full border text-left">
                <thead class="bg-green-100">
                    <tr>
                        <th class="p-2 border-b">ID</th>
                        <th class="p-2 border-b">Username</th>
                        <th class="p-2 border-b">Full Name</th>
                        <th class="p-2 border-b">Phone</th>
                        <th class="p-2 border-b">Role</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="customer in filteredCustomers()" :key="customer.id">
                        <tr class="hover:bg-green-50">
                            <td class="p-2 border-b" x-text="customer.id"></td>
                            <td class="p-2 border-b" x-text="customer.username"></td>
                            <td class="p-2 border-b" x-text="customer.fullname"></td>
                            <td class="p-2 border-b" x-text="customer.phone || '-'"></td>
                            <td class="p-2 border-b align-top">
                                <span class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full">
                                    Customer
                                </span>

                                <div class="mt-2 flex space-x-2">
                                    <button 
                                        @click="editUser(customer)"
                                        class="flex items-center gap-1 text-yellow-600 hover:text-yellow-800 transition text-sm font-medium"
                                    >
                                        <i class="fas fa-edit"></i> Edit
                                    </button>

                                    <button 
                                        @click="deleteUser(customer.id)"
                                        class="flex items-center gap-1 text-red-600 hover:text-red-800 transition text-sm font-medium"
                                    >
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Modal -->
    <div x-show="modalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-transition>
        <div @click.outside="closeModal" class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
            <h3 class="text-lg font-semibold mb-4">Register New User</h3>
            <form @submit.prevent="submitForm">
                <div class="mb-3">
                    <label class="block font-medium">Username</label>
                    <input type="text" x-model="form.username" required class="w-full border rounded p-2" />
                </div>
                <div class="mb-3">
                    <label class="block font-medium">Full Name</label>
                    <input type="text" x-model="form.fullname" required class="w-full border rounded p-2" />
                </div>
                <div class="mb-3">
                    <label class="block font-medium">Phone</label>
                    <input type="text" x-model="form.phone" class="w-full border rounded p-2" />
                </div>
                <div class="mb-3">
                    <label class="block font-medium">Password</label>
                    <input type="password" x-model="form.password" required class="w-full border rounded p-2" />
                </div>
                <div class="mb-4">
                    <label class="block font-medium">Role</label>
                    <select x-model="form.role" required class="w-full border rounded p-2">
                        <option value="">-- Select Role --</option>
                        <option value="staff">Staff</option>
                        <option value="customer">Customer</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="closeModal" class="px-4 py-2 border rounded">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Register</button>
                </div>
            </form>

            <template x-if="formErrors.length">
                <div class="mt-4 bg-red-100 text-red-700 border border-red-300 rounded p-2">
                    <ul>
                        <template x-for="error in formErrors" :key="error">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                </div>
            </template>
        </div>
    </div>
    <script>
        function userManagement() {
            return {
                staffs: @json($staffs),
                customers: @json($customers),
                staffOpen: true,
                customerOpen: true,
                staffSearch: '',
                customerSearch: '',
                modalOpen: false,
                isEditing: false,
                editingId: null,
                formErrors: [],
                form: {
                    username: '',
                    fullname: '',
                    phone: '',
                    password: '',
                    role: '',
                },

                // Modal controls
                openModal() {
                    this.modalOpen = true;
                    this.clearForm();
                    this.isEditing = false;
                },

                closeModal() {
                    this.modalOpen = false;
                    this.formErrors = [];
                    this.isEditing = false;
                    this.editingId = null;
                },

                // Filtering
                filteredStaffs() {
                    if (!this.staffSearch) return this.staffs;
                    return this.staffs.filter(user =>
                        user.username.toLowerCase().includes(this.staffSearch.toLowerCase()) ||
                        user.fullname.toLowerCase().includes(this.staffSearch.toLowerCase())
                    );
                },

                filteredCustomers() {
                    if (!this.customerSearch) return this.customers;
                    return this.customers.filter(user =>
                        user.username.toLowerCase().includes(this.customerSearch.toLowerCase()) ||
                        user.fullname.toLowerCase().includes(this.customerSearch.toLowerCase())
                    );
                },

                // Form
                clearForm() {
                    this.form = {
                        username: '',
                        fullname: '',
                        phone: '',
                        password: '',
                        role: '',
                    };
                    this.formErrors = [];
                },

                editUser(user) {
                    this.openModal();
                    this.isEditing = true;
                    this.editingId = user.id;
                    this.form = {
                        username: user.username,
                        fullname: user.fullname,
                        phone: user.phone,
                        password: '',
                        role: user.role,
                    };
                },

                async deleteUser(id) {
                    const confirm = await Swal.fire({
                        title: 'Are you sure?',
                        text: 'This user will be permanently deleted.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    });

                    if (!confirm.isConfirmed) return;

                    try {
                        const res = await fetch(`/users/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });

                        if (!res.ok) throw new Error();

                        // Remove from local list
                        this.staffs = this.staffs.filter(u => u.id !== id);
                        this.customers = this.customers.filter(u => u.id !== id);

                        Swal.fire('Deleted!', 'User has been removed.', 'success');
                    } catch (e) {
                        Swal.fire('Error!', 'Failed to delete user.', 'error');
                    }
                },

                async submitForm() {
                    this.formErrors = [];

                    try {
                        const url = this.isEditing
                            ? `/users/${this.editingId}`
                            : "{{ route('user.register') }}";

                        const method = this.isEditing ? 'PUT' : 'POST';

                        const response = await fetch(url, {
                            method,
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify(this.form)
                        });

                        const result = await response.json();

                        if (!response.ok) {
                            this.formErrors = result.errors
                                ? Object.values(result.errors).flat()
                                : [result.message || 'Something went wrong'];
                            return;
                        }

                        if (this.isEditing) {
                            let list = result.role === 'staff' ? this.staffs : this.customers;
                            const index = list.findIndex(u => u.id === result.id);
                            if (index !== -1) list[index] = result;
                        } else {
                            if (result.role === 'staff') this.staffs.push(result);
                            else if (result.role === 'customer') this.customers.push(result);
                        }

                        this.closeModal();

                        Swal.fire({
                            title: 'Success!',
                            text: this.isEditing ? 'User updated successfully!' : 'User registered successfully!',
                            icon: 'success',
                            confirmButtonColor: '#3085d6'
                        });

                    } catch (e) {
                        this.formErrors = ['Failed to process request. Please try again.'];
                    }
                }
            };
        }
    </script>

</div>
@endsection
