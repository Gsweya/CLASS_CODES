# Linked List Visualizer - Interactive Educational Game

An interactive educational tool that visually demonstrates how **singly linked lists** work at the **pointer level**, matching classic textbook diagrams. This tool allows learners to manually manipulate pointer statements and immediately see how the linked list structure changes, including correct behavior and common pointer mistakes.

## Features

### Visual Design
- **Node Display**: Each node is shown as a rectangle split into `info` (value) and `link` (pointer) fields
- **Pointer Arrows**: Visual arrows represent pointer relationships
- **Head Pointer**: Clearly displayed with distinct styling
- **NULL Visualization**: NULL pointers are explicitly shown in red
- **Loop Detection**: Looping arrows are displayed when cycles are detected
- **Lost Nodes**: Unreachable nodes are grayed out and labeled "Lost / Unreachable"

### Supported Operations

1. **Create List**: Initialize a linked list with nodes
2. **Traverse List**: Step-by-step traversal with highlighting
3. **Insert at Beginning**: Visual pointer rewiring
4. **Insert at End**: Traverse until NULL and attach
5. **Insert in Middle**: 
   - Using one pointer (`p`)
   - Using two pointers (`p` and `q`)
   - User can choose statement order
6. **Wrong Order Demonstration**: Shows what happens when statements are executed in the wrong order (self-loops, lost nodes)
7. **Delete Node**: Delete from beginning, middle, or end
8. **Search**: Highlight nodes during search

### Code-Driven Interaction

- **C-Style Editor**: Type or select statements like:
  ```c
  p = head->link;
  newNode->link = p->link;
  p->link = newNode;
  ```
- **Step-by-Step Execution**: Each statement executes one at a time
- **Real-time Visualization**: Updates after every statement
- **Plain English Explanations**: What changed, what was preserved, what would break

### Game Mechanics

- **Challenges**: 
  - "Insert 50 after 65 without losing nodes"
  - "Fix the broken list"
  - "Identify why traversal is infinite"
- **Scoring**: Based on correct pointer order and no memory loss
- **Visual Warnings**: Alerts for infinite loops and lost nodes

## Getting Started

### Prerequisites

- Node.js (v16 or higher)
- npm or yarn

### Installation

1. Install dependencies:
```bash
npm install
```

2. Start the development server:
```bash
npm run dev
```

3. Open your browser to the URL shown in the terminal (typically `http://localhost:5173`)

### Build for Production

```bash
npm run build
```

The built files will be in the `dist` directory.

## Usage

### Basic Operations

1. **Create a List**: Click "Create List" to initialize a list with nodes (10, 20, 30)

2. **Execute Statements**: Type C-style pointer statements in the code editor:
   - `p = head` - Assign pointer p to head
   - `p = head->link` - Traverse one node
   - `newNode = createNode(50)` - Create a new node
   - `newNode->link = p->link` - Preserve the remainder
   - `p->link = newNode` - Insert the new node

3. **Use Quick Operations**: Click operation buttons for common tasks

4. **Try Challenges**: Select a challenge from the challenge panel

### Statement Syntax

Supported statement formats:
- `p = head` - Assign pointer to head
- `p = NULL` - Set pointer to NULL
- `p = q` - Copy pointer
- `p = q->link` - Dereference pointer
- `newNode = createNode(value)` - Create new node
- `p->link = q` - Set link field
- `p->link = NULL` - Set link to NULL
- `head = p` - Update head pointer
- `delete p` - Delete node

### Understanding the Visualization

- **Blue nodes**: Normal nodes in the list
- **Green nodes**: Highlighted/current nodes
- **Gray nodes**: Lost/unreachable nodes
- **Red arrows**: Head pointer or loop indicators
- **Dashed lines**: Other pointer variables (p, q, newNode, etc.)
- **Red "NULL" text**: NULL pointer

## Educational Value

This tool helps students understand:
- Why pointer order matters in linked list operations
- How incorrect statement order can break the list
- What happens to memory when nodes become unreachable
- How loops are created and detected
- The relationship between pointers and actual memory locations

## Technology Stack

- **React 18**: UI framework
- **TypeScript**: Type safety
- **Vite**: Build tool and dev server
- **SVG**: Visualization rendering

## Project Structure

```
src/
├── components/
│   ├── LinkedListVisualization.tsx  # SVG visualization
│   ├── CodeEditor.tsx              # C-style code editor
│   ├── ExplanationPanel.tsx        # Teaching explanations
│   ├── OperationButtons.tsx        # Quick operation buttons
│   └── ChallengePanel.tsx          # Challenge system
├── utils/
│   └── linkedListEngine.ts         # Core linked list logic
├── types.ts                        # TypeScript types
├── App.tsx                         # Main application
└── main.tsx                        # Entry point
```

## Contributing

This is an educational tool. Feel free to:
- Report bugs
- Suggest improvements
- Add new challenges
- Enhance visualizations

## License

This project is created for educational purposes.


