export async function fetchPermissionsForRole(roleId) {
    const res = await fetch(`/api/permissions/${roleId}/roles`);
    const data = await res.json();
  
    return {
      assigned: data.data,
    };
  }

  export async function fetchPermissionsNotContainRole(roleId) {
    const res = await fetch(`/api/permissions/${roleId}/rolesnotcontain`);
    const data = await res.json();
  
    return {
      unassigned: data.data,
    };
  }
  
  export async function assignPermissionsToRole(roleId, permissions) {
    const res = await fetch(`/api/roles/${roleId}/permissions`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        permissions: permissions,
      }),
    });
  
    return await res.json();
  }
  
  export async function removePermissionsFromRole(roleId, permissions) {
    const res = await fetch(`/api/roles/${roleId}/permissions`, {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        permissions: permissions,
      }),
    });
  
    return await res.json();
  }
  