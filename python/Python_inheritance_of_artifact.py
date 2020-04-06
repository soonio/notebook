 # coding=utf-8


class Init:
    def __init__(self):
        print('i test')
        if hasattr(self, 'init'):
            self.init()


class A:
    def __init__(self):
        print('self-A')


class B(A):
    def __init__(self):
        print('B->A')
        super(B, self).__init__()
        print('A->B')


class C(Init, B):
    def __init__(self):
        print('C->B')
        super(Init, self).__init__()
        super(C, self).__init__()
        print('B->C')

    def init(self):
        print('init')


C()

