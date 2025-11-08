# 📋 TODO LIST

## 🏗️ Arquitectura MVC

### **Modelo (M)**
- `todoModel.php` - Maneja operaciones de base de datos
- `Model.php` (clase base) - Proporciona métodos CRUD genéricos

### **Vista (V)**
- `todolist.php` - Lista principal de tareas
- `addTodo.php` - Formulario para nuevas tareas
- `editTodo.php` - Formulario para editar tareas
- `inc_header.php` - Navegación y estructura base
- `inc_footer.php` - Scripts y cierre

### **Controlador (C)**
- `todoController.php` - Lógica de negocio
- `Controller.php` (clase base) - Métodos helper comunes

## 🔄 FLUJO COMPLETO DE LA APLICACIÓN

### **1. INICIO DE LA APLICACIÓN**
```
Usuario accede → index.php → Core::run() → Autoloader → Configuración
```

**Archivos involucrados:**
- `index.php` - Punto de entrada
- `Core.php` - Inicializa el framework
- `core_config.php` - Configuración global
- `Autoloader.php` - Carga automática de clases

### **2. NAVEGACIÓN A TODO LIST**
```
URL: /todo → Core::dispatch() → todoController::index()
```

**Flujo detallado:**
1. Usuario hace clic en "Todo List" o escribe `/todo`
2. `Core.php` procesa la URL con `filter_url()`
3. `dispatch()` determina controlador: `todoController`
4. `dispatch()` determina método: `index`
5. Se instancia `todoController` y ejecuta `index()`

### **3. CARGAR LISTA DE TAREAS**
```
todoController::index() → todoModel::getAllWithDetails() → View::render()
```

**Proceso paso a paso:**
1. **Controlador** (`todoController::index()`):
   - Llama a `todoModel::getAllWithDetails()`
   - Prepara datos para la vista
   - Llama a `View::render('todolist', $data)`

2. **Modelo** (`todoModel::getAllWithDetails()`):
   - Extiende `Model::all()` (clase base)
   - Ejecuta consulta SQL: `SELECT * FROM todos ORDER BY created_at DESC`
   - Procesa cada tarea con `Todo::getPriorityText()` y `Todo::getPriorityColor()`
   - Retorna array con datos procesados

3. **Vista** (`todolist.php`):
   - Incluye `inc_header.php` (navegación)
   - Muestra `Toast::flash()` (notificaciones)
   - Renderiza lista de tareas con Bootstrap
   - Incluye `inc_footer.php` (scripts)

### **4. AGREGAR NUEVA TAREA**
```
Formulario → todoController::store() → todoModel::create() → Redirect::to()
```

**Flujo completo:**
1. **Usuario accede al formulario**:
   - URL: `/todo/add`
   - `todoController::add()` renderiza `addTodo.php`

2. **Usuario envía formulario**:
   - POST a `/todo/store`
   - `todoController::store()` procesa datos

3. **Validación**:
   - `$this->validatePost(['task'])` verifica campos requeridos
   - Si falla: `Toast::new()` + `Redirect::to()`

4. **Guardado**:
   - `todoModel::create($todoData)` extiende `Model::create()`
   - Ejecuta `INSERT INTO todos` con prepared statements

5. **Redirección**:
   - `$this->redirectWithMessage('todo', 'Tarea agregada exitosamente', 'success')`
   - `Toast::new()` guarda mensaje en `$_SESSION`
   - `Redirect::to()` redirige a `/todo`

6. **Confirmación**:
   - Usuario llega a `/todo`
   - `Toast::flash()` lee mensaje de `$_SESSION` y lo muestra
   - Mensaje se auto-elimina de `$_SESSION`

### **5. EDITAR TAREA EXISTENTE**
```
Formulario → todoController::update() → todoModel::update() → Redirect::to()
```

**Flujo completo:**
1. **Usuario accede al formulario de edición**:
   - Hace clic en botón "Editar" de una tarea
   - URL: `/todo/edit?id=123`
   - `todoController::edit()` busca la tarea con `todoModel::find()`
   - Renderiza `editTodo.php` con datos pre-cargados

2. **Usuario modifica y envía formulario**:
   - POST a `/todo/update`
   - `todoController::update()` procesa datos

3. **Validación**:
   - Valida ID y campos requeridos
   - Si falla: redirección con mensaje de error

4. **Actualización**:
   - `todoModel::update($id, $todoData)` extiende `Model::update()`
   - Ejecuta `UPDATE todos SET task = ?, description = ?, priority = ? WHERE id = ?`

5. **Confirmación**:
   - Redirección a `/todo` con mensaje de éxito

### **6. CAMBIAR ESTADO DE TAREA**
```
Enlace → todoController::toggle() → Todo::toggleStatus() → Redirect::to()
```

**Proceso:**
1. Usuario hace clic en botón de estado
2. GET a `/todo/toggle?id=123`
3. `todoController::toggle()`:
   - Valida ID
   - Verifica que tarea existe con `todoModel::find()`
   - Llama a `Todo::toggleStatus()`
4. `Todo::toggleStatus()` ejecuta: `UPDATE todos SET completed = NOT completed WHERE id = ?`
5. Redirección con mensaje de confirmación

### **7. ELIMINAR TAREA**
```
Enlace → Confirmación JS → todoController::delete() → todoModel::delete()
```

**Flujo:**
1. Usuario hace clic en botón eliminar
2. JavaScript muestra `confirm('¿Eliminar esta tarea?')`
3. Si confirma: GET a `/todo/delete?id=123`
4. `todoController::delete()`:
   - Valida ID
   - Verifica existencia
   - Llama a `todoModel::delete()`
5. `todoModel::delete()` extiende `Model::delete()`
6. Ejecuta: `DELETE FROM todos WHERE id = ?`
7. Redirección con mensaje de confirmación

### **8. BÚSQUEDA DE TAREAS**
```
Formulario → todoController::search() → todoModel::search()
```

**Proceso:**
1. Usuario escribe en barra de búsqueda
2. GET a `/todo/search?q=texto`
3. `todoController::search()`:
   - Valida término de búsqueda
   - Llama a `todoModel::search($search)`
4. `todoModel::search()` ejecuta: `SELECT * FROM todos WHERE task LIKE ? OR description LIKE ?`
5. Renderiza misma vista con resultados filtrados

## 🔧 COMPONENTES DEL FRAMEWORK UTILIZADOS

### **Core.php**
- ✅ `init()` - Inicialización del sistema
- ✅ `filter_url()` - Procesamiento de URLs
- ✅ `dispatch()` - Enrutamiento automático

### **Db.php**
- ✅ `query()` - Consultas preparadas seguras
- ✅ Conexión PDO automática
- ✅ Manejo de errores

### **Toast.php**
- ✅ `new()` - Guardar notificaciones en sesión
- ✅ `flash()` - Mostrar y auto-eliminar notificaciones
- ✅ Tipos: success, warning, danger, info

### **Redirect.php**
- ✅ `to()` - Redirecciones robustas
- ✅ Fallback JavaScript si headers enviados
- ✅ Soporte URLs internas y externas

### **View.php**
- ✅ `render()` - Renderización de vistas
- ✅ `to_Object()` - Conversión array a objeto

### **Autoloader.php**
- ✅ Carga automática de clases
- ✅ Soporte para Controllers, Models, Classes

## 🌐 URLs DEL SISTEMA

| URL | Controlador | Método | Descripción |
|-----|-------------|--------|-------------|
| `/todo` | todoController | index | Lista principal |
| `/todo/add` | todoController | add | Formulario nueva tarea |
| `/todo/store` | todoController | store | Procesar nueva tarea |
| `/todo/edit?id=1` | todoController | edit | Formulario editar tarea |
| `/todo/update` | todoController | update | Procesar edición tarea |
| `/todo/toggle?id=1` | todoController | toggle | Cambiar estado |
| `/todo/delete?id=1` | todoController | delete | Eliminar tarea |
| `/todo/search?q=texto` | todoController | search | Buscar tareas |


## 🚀 INSTALACIÓN

1. **Crear tabla**: Ejecutar `create_todos_table.sql`
2. **Archivos**: Copiar todos los archivos según estructura
3. **Configurar**: Verificar `core_config.php` (BD)
4. **Acceder**: `http://localhost/proyecto/todo`

¡El sistema está listo para usar! 🎉

---

## 📝 TAREAS PENDIENTES / CONSIGNAS

### **Tarea 1: Agregar Campo "Favorito/Importante"**
**Objetivo:** Implementar un campo adicional para marcar tareas como favoritas o importantes.

**Requisitos:**
- Agregar columna `favorite` o `important` (    ) a la tabla `todos`
- Mostrar el estado de favorito de forma similar al botón "Completar"
- Agregar botón para marcar/desmarcar como favorito en la lista de tareas
- El botón debe cambiar de estilo cuando la tarea está marcada como favorita
- Implementar método `toggleFavorite()` en el controlador
- Actualizar el modelo para manejar este nuevo campo

**Archivos a modificar:**
- `create_todos_table.sql` - Agregar columna
- `app/controllers/todoController.php` - Método toggleFavorite
- `app/models/todoModel.php` - Si es necesario
- `templates/views/todo/todolist.php` - Botón y visualización
- `templates/views/todo/addTodo.php` - Campo en formulario
- `templates/views/todo/editTodo.php` - Campo en formulario

---

### **Tarea 2: Mover Botón "Nueva Tarea" al Título**
**Objetivo:** Mejorar la usabilidad moviendo el botón "Nueva Tarea" junto al título principal.

**Requisitos:**
- Remover el botón "Nueva Tarea" del panel lateral "Sistema de Tareas"
- Agregar el botón junto al título "Mi Lista de Tareas" en la parte superior
- El título y el botón deben estar alineados (título a la izquierda, botón a la derecha)
- Usar clases de Bootstrap para alineación: `d-flex justify-content-between align-items-center`

**Archivos a modificar:**
- `templates/views/todo/todolist.php` - Líneas 8-10 (título) y líneas 90-103 (panel lateral)

**Ejemplo de implementación:**
```php
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><?= $data['page_title'] ?? 'Mi Lista de Tareas' ?></h1>
    <a href="<?= URL ?>todo/add" class="btn btn-primary">Nueva Tarea</a>
</div>
```

---

### **Tarea 3: Mejorar Claridad del Botón "Completar"**
**Objetivo:** Hacer más evidente cuándo una tarea está completada.

**Requisitos:**
- Cambiar el texto del botón cuando la tarea está completada:
  - **Pendiente:** "Marcar Completada" (botón verde sólido `btn-success`)
  - **Completada:** "✓ Completada" (botón verde outline `btn-outline-success` con check)
- Mantener la funcionalidad de toggle (cambiar estado al hacer clic)
- Considerar agregar un badge o indicador visual adicional en tareas completadas

**Archivos a modificar:**
- `templates/views/todo/todolist.php` - Líneas 62-65 (botón de completar)

**Ejemplo de implementación:**
```php
<a href="<?= URL ?>todo/toggle?id=<?= $todo['id'] ?>" 
   class="btn btn-sm <?= $todo['completed'] ? 'btn-outline-success' : 'btn-success' ?>">
    <?= $todo['completed'] ? '✓ Completada' : 'Marcar Completada' ?>
</a>
```

---

### **Tarea 4: Agregar Modal de Confirmación al Eliminar**
**Objetivo:** Mejorar la experiencia de usuario usando un modal de Bootstrap en lugar del `confirm()` nativo de JavaScript.

**Requisitos:**
- Crear un modal de Bootstrap para confirmación de eliminación
- El modal debe mostrar:
  - Título: "¿Eliminar tarea?"
  - Mensaje: "Esta acción no se puede deshacer. ¿Estás seguro de eliminar esta tarea?"
  - Botón "Cancelar" (secundario)
  - Botón "Eliminar" (danger/rojo)
- Remover el `onclick="return confirm('¿Eliminar esta tarea?')"` del enlace
- Usar atributos `data-bs-toggle="modal"` y `data-bs-target="#deleteModal"`
- El modal debe recibir el ID de la tarea a eliminar dinámicamente

**Archivos a modificar:**
- `templates/views/todo/todolist.php` - Botón eliminar y agregar modal al final
- `templates/includes/inc_footer.php` - JavaScript para pasar el ID al modal (opcional)

**Ejemplo de implementación del modal:**
```php
<!-- Modal de confirmación -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">¿Eliminar tarea?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Esta acción no se puede deshacer. ¿Estás seguro de eliminar esta tarea?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="#" id="confirmDelete" class="btn btn-danger">Eliminar</a>
            </div>
        </div>
    </div>
</div>
```

---


