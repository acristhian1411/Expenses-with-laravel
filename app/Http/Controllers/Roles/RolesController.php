<?php

namespace App\Http\Controllers\Roles;

use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Spatie\Permission\Models\Permission;

class RolesController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $t = Role::query()->first();
            $query = Role::query();
            $query = $this->filterData($query, $t);
            $datos = $query->get();
            return $this->showAll($datos, 200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo obtener los datos'],500);
        }
    }

    public function assignPermissionsToRole(Request $request, $roleId)
    {
        try {
            // Validamos que los permisos vengan en un array
            // $validatedData = $request->validate([
            //     'permissions' => 'required|array',
            //     'permissions.*' => 'exists:permissions,name', // Verifica que los permisos existan por nombre
            // ]);

            // Buscamos el rol por ID
            $role = Role::findOrFail($roleId);

            // Asignamos los permisos al rol
            foreach ($request->permissions as $permission) {
                $role->givePermissionTo($permission); // syncPermissions asigna los nuevos permisos y elimina los antiguos que no están en la lista
            }
            return response()->json([
                'message' => 'Permisos asignados correctamente al rol',
                'data' => $role->permissions,
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Los datos no son válidos',
                'details' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'No se pudo asignar los permisos al rol',
            ], 400);
        }
    }

    public function removePermissionsFromRole(Request $request, $roleId)
    {
        try {
            // Validamos que los permisos vengan en un array
            $validatedData = $request->validate([
                'permissions' => 'required|array',
                'permissions.*' => 'exists:permissions,name', // Verifica que los permisos existan por nombre
            ]);

            // Buscamos el rol por ID
            $role = Role::findOrFail($roleId);

            // Removemos los permisos indicados
            $role->revokePermissionTo($validatedData['permissions']);

            return response()->json([
                'message' => 'Permisos removidos correctamente del rol',
                'data' => $role->permissions,
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Los datos no son válidos',
                'details' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'No se pudo remover los permisos del rol',
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $rules=[
                'name' => 'required|string|max:255',
            ];
            $request->validate($rules);
            $role = Role::create($request->all());
            return response()->json(['message'=>'Registro creado con exito','data'=>$role]);
        }catch(\Illuminate\Validation\ValidationException $e){
            // dd($e);
            return response()->json([
                'error'=>$e->getMessage(),
                'message'=>'Los datos no son correctos',
                'details' => method_exists($e, 'errors') ? $e->errors() : null 
            ],422);
        }
        catch(\Exception $e){
            return response()->json(['error'=> $e->getMessage(),'message'=>'No se pudo crear registro'],400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $role = Role::find($id);
            $audits = $role->audits;
            return $this->showOne($role,$audits,200);
        } catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo obtener los datos'],500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request,$id)
    {
        try{
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            // Update the till type
            $Role = Role::findOrFail($id);
            $Role->update($validatedData);
            // Return a success response
            return response()->json(['message'=>'Registro Actualizado con exito','data'=>$Role]);
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json([
                'error'=>$e->getMessage(),
                'message'=>'Los datos no son correctos',
                'details' => method_exists($e, 'errors') ? $e->errors() : null 
            ],422);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo actualizar los datos'],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $Role = Role::findOrFail($id);
            $Role->delete();
            return response()->json(['message'=>'Eliminado con exito']);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo eliminar los datos'],500);
        }
    }
}